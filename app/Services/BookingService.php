<?php

namespace App\Services;

use App\Models\OperatorExceptionAvailability;
use App\Models\OperatorWeeklyAvailability;
use App\Models\Reserve;
use App\Models\ServiceApplicationPlace;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\Exception;

class BookingService
{
    public function number_of_bookable_for_slot($service_application_place_id, $from, $to): int
    {
        if (!$this->slot_is_available($service_application_place_id, $from, $to))
            return 1;
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $from.":00");
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $to.":00");
        $booked = sizeof($this->slot_booked($service_application_place_id, $from, $to));
        $capacity = ServiceApplicationPlace::find($service_application_place_id)->serviceApplication->getCapacity();
        return $capacity - $booked;
    }
    public function slot_booked($service_application_place_id, $from, $to): array|null
    {
        $service_application_place = ServiceApplicationPlace::find($service_application_place_id);
        $service_application_id = $service_application_place->serviceApplication->id;
        $operator_id = $service_application_place->serviceApplication->operator->id;
//        $parallel = $service_application_place->parallel;
//        $address_id = $service_application_place->address_id;
        try {
//           return Reserve::where(function(Builder $query)use($service_application_place_id,$operator_id,$parallel,$address_id){
//                return $query->where('service_application_place_id', $service_application_place_id)
//                    ->orWhereHas('serviceApplicationPlace',function(Builder $query)use($operator_id,$parallel,$address_id){
//                        return $query->where(function (Builder $query)use ($parallel,$address_id){
//                             return $query->where('parallel',0)->orWhere('parallel','!=',$parallel)
//                                    ->orWhere('address_id','!=',$address_id);
//                        })->whereHas('serviceApplication',function (Builder $query)use($operator_id){
//                            return $query->where('operator_id',$operator_id);
//                        });
//                    });
//            })->where('status','!=','CANCELED')
//                ->where('from', '<', $to->timestamp)->where('to', '>', $from->timestamp)
//                ->get()->toArray();
            return Reserve::whereHas('serviceApplicationPlace',function (Builder $builder)use($operator_id){
                return $builder->whereHas('serviceApplication',function (Builder $builder)use($operator_id){
                    return $builder->where('operator_id',$operator_id);
                });
            })->where('status','!=','CANCELED')
                ->where('from', '<', $to->timestamp)->where('to', '>', $from->timestamp)
                ->get()->toArray();
        }catch (\Exception $exception){
            throw new \Exception($exception,1);
        }
    }

    public function slot_is_available($service_application_place_id, $from, $to): bool
    {
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $from.":00");
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $to.":00");
        $day = Carbon::createFromFormat('Y-m-d H:i:s',$from->format('Y-m-d')." 00:00:00");
        $slots = $this->slots($service_application_place_id,$from,$to,$day);
        foreach ($slots as $slot)
        {
            if($slot['from']->eq($from) && $slot['to']->eq($to))
                return true;
        }
        return  false;
    }

    public function getDayMinutes(Carbon $carbon_date): int
    {
        return intval($carbon_date->format('H')) * 60 + intval($carbon_date->format('i'));
    }

    /**
     * @throws \Exception
     */
    public function slots($service_application_place_id, Carbon $from, Carbon $to, Carbon $day) : array
    {

        $service_application_place = ServiceApplicationPlace::find($service_application_place_id);
        $slots = [];
        if ($service_application_place) {
            $service_application = $service_application_place->serviceApplication;
            $service = $service_application->service;
            $duration = $service_application->duration ?? $service->default_duration;
            $break = $service_application->break ?? $service->default_break;
            $capacity = $service_application->capacity ?? $service->default_capacity;
            $weekday = intval($from->dayOfWeek) + 1;
            $weekday = $weekday > 6 ? $weekday - 7 : $weekday;
            $shifts = OperatorWeeklyAvailability::where('weekday', $weekday . "")->where('place_id', $service_application_place_id)
                ->where('from', '<', $this->getDayMinutes($to))
                ->where('to', '>', $this->getDayMinutes($from))->get()->toArray();

            $exceptionTimes = OperatorExceptionAvailability::where('place_id', $service_application_place_id)
                ->where('from', '<', $to)->where('to', '>', $from)->get()->toArray();
            $shifts = $this->calculateShifts($shifts, $exceptionTimes, $day);

            foreach ($shifts as $shift) {
                $shift_to_carbon = Carbon::createFromTimestamp($day->timestamp + ($shift['to'] * 60));
                $slot_from_carbon = Carbon::createFromTimestamp($day->timestamp + ($shift['from'] * 60));
                $slot_to_carbon = Carbon::createFromTimestamp($day->timestamp + ($shift['from'] * 60));
                $slot_to_carbon = $slot_to_carbon->addMinutes($duration);
                $slot_from_carbon->subMinutes($break);
                $slot_to_carbon->subMinutes($break);
                for ($i = 0; $shift_to_carbon->gte($slot_to_carbon->addMinutes($break));$i++) {
                    $slot_from_carbon = $slot_from_carbon->addMinutes($break);
                    $booked = $this->slot_booked($service_application_place_id,$slot_from_carbon, $slot_to_carbon);
                    $isAvailable = sizeOf($booked) >= $capacity ? 0 : 1;
                    $slots[$i] = [
//                        'from' => $slot_from_carbon->format('Y-m-d H:i'),
                        'from' => clone($slot_from_carbon),
//                        'to' => $slot_to_carbon->format('Y-m-d H:i'),
                        'to' => clone($slot_to_carbon) ,
                        'isAvailable' => $isAvailable,
                        'booked' => [
                            'number' => sizeOf($booked),
                            'reserves' => $booked
                        ]
                    ];
                    $slot_from_carbon = $slot_from_carbon->addMinutes($duration);
                    $slot_to_carbon = $slot_to_carbon->addMinutes($duration);

                }
            }
        }
        return array_values($slots);
    }

    public function calculateShifts($times, $exceptionTimes, $date): array
    {


        $increaseTimes = [];
        $decreaseTimes = [];


        foreach ($exceptionTimes as $time) {
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $time['from']);
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $time['to']);

            if ($time['isAvailable']) {
                $increaseTimes[] = [
                    'from' => $from->gt($date) ? intval($from->format('H')) * 60 + intval($from->format('i')) : 0,
                    'to' => $to->gt($date->addDay()) ? 24 : intval($to->format('H')) * 60 +  intval($to->format('i'))
                ];
            } else {
                $decreaseTimes[] = [
                    'from' => $from->gt($date) ? intval($from->format('H')) * 60 + intval($from->format('i')) : 0,
                    'to' => $to->gt($date->addDay()) ? 24 : intval($to->format('H')) * 60 + intval($to->format('i'))
                ];
            }
        }

        $times = array_merge($times, $increaseTimes);
        usort($times, function ($a, $b) {
            return $a['from'] - $b['from'];
        });
        $times = $this->union($times);
        $times_array = array_values($times);

        foreach ($decreaseTimes as $key => $decreaseTime) {
            foreach ($times_array as $array_key => $time) {
                if ($time['from'] < $decreaseTime['to'] && $time['to'] > $decreaseTime['from']) {
                    if ($time['from'] > $decreaseTime['from'] && $time['to'] < $decreaseTime['to'])
                        unset($times[$array_key]);
                    elseif ($time['from'] < $decreaseTime['from'] && $time['to'] > $decreaseTime['to']) {
                        $temp_1 = [
                            'from' => $time['from'],
                            'to' => $decreaseTime['from']
                        ];

                        $temp_2 = [
                            'from' => $decreaseTime['to'],
                            'to' => $time['to']
                        ];
                        unset($times[$array_key]);
                        $times[] = $temp_1;
                        $times[] = $temp_2;
                    } elseif ($time['from'] < $decreaseTime['from']) {
                        $times[$array_key]['to'] = $decreaseTime['from'];
                    } else {
                        $times[$array_key]['from'] = $decreaseTime['to'];
                    }

                }
            }
        }
        usort($times, function ($a, $b) {
            return $a['from'] - $b['from'];
        });
        return $times;
    }

    public function union($times)
    {
        if (sizeof($times) > 1) {
            if ($times[1]['from'] <= $times[0]['to']) {
                if ($times[1]['to'] > $times[0]['to'])
                    $times[0]['to'] = $times[1]['to'];
                unset($times[1]);
                $times = array_values($times);
                return $this->union($times);
            } else {
                $temp[] = $times[0];
                unset($times[0]);
                $times = array_values($times);
                return array_merge($temp, $this->union($times));
            }
        } else {
            return $times;
        }
    }

}

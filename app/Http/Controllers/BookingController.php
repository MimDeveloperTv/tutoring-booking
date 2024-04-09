<?php

namespace App\Http\Controllers;

use App\Models\OperatorExceptionAvailability;
use App\Models\OperatorWeeklyAvailability;
use App\Models\Reserve;
use App\Models\ServiceApplicationPlace;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private BookingService $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function slots(Request $request)
    {
        $service_application_place_id = $request->place_id;
        $from_date =strtotime(date("Y-m-d", time()));
        $toDate = $request->to_date . " 00:00:00";
        $to_date = Carbon::createFromFormat('Y-m-d H:i:s', $toDate)->getTimestamp();

        $service_application_place = ServiceApplicationPlace::find($service_application_place_id);
        if ($service_application_place) {
            $service_application = $service_application_place->serviceApplication;
            $service = $service_application->service;
            $duration = $service_application->duration ?? $service->default_duration;
            $break = $service_application->break ?? $service->default_break;
            $capacity = $service_application->capacity ?? $service->default_capacity;
            $all_days = ($to_date - $from_date) / 86400;
            $slots = [];

            for ($i = 0; $i < $all_days; $i++) {

                $current_day = Carbon::createFromTimestamp($from_date + $i * 86400);
                $tomorrow = Carbon::createFromTimestamp($from_date + ($i + 1) * 86400);
                $slots[$i] = [];
                $slots[$i]['date'] = $current_day->format('Y-m-d');
                $slots[$i]['capacity'] = $capacity;
                $slots[$i]['slots'] = [];
                $weekday = date('w', $from_date + $i * 86400) + 1;
                $weekday = $weekday > 6 ? $weekday - 7 : $weekday;

                $shifts = OperatorWeeklyAvailability::where('weekday', $weekday . "")
                    ->where('place_id', $service_application_place_id)
                    ->orderBy('from', 'ASC')->get()->toArray();

                $exceptionTimes = OperatorExceptionAvailability::where('place_id', $service_application_place_id)
                    ->where('from', '<', $tomorrow)->where('to', '>', $current_day)->orderBy('from', 'ASC')->get()->toArray();

                $shifts = $this->bookingService->calculateShifts($shifts, $exceptionTimes, $current_day);

                foreach ($shifts as $shift) {
                    $shift_to_carbon = Carbon::createFromTimestamp($from_date + $i * 86400 + ($shift['to'] * 60));
                    $slot_from_carbon = Carbon::createFromTimestamp($from_date + $i * 86400 + ($shift['from'] * 60),);
                    $slot_to_carbon = Carbon::createFromTimestamp($from_date + $i * 86400 + ($shift['from'] * 60));
                    $slot_to_carbon = $slot_to_carbon->addMinutes($duration);
                    $slot_from_carbon->subMinutes($break);
                    $slot_to_carbon->subMinutes($break);

                    for (; $shift_to_carbon->gte($slot_to_carbon->addMinutes($break)); ) {

                        $slot_from_carbon = $slot_from_carbon->addMinutes($break);
                        $booked = $this->bookingService->slot_booked($service_application_place_id,$slot_from_carbon,$slot_to_carbon);
                        $isAvailable = sizeOf($booked) >= $capacity ? 0 : 1;
                        $slots[$i]['slots'][] = [
                            'from' => $slot_from_carbon->format('H:i'),
                            'to' => $slot_to_carbon->format('H:i'),
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
                if(!sizeof($slots[$i]['slots']))
                   unset($slots[$i]);

            }
            $slots = array_values($slots);
        }
        else
        {
            return response()->json([
                'errors' => [
                    'message' => 'This service is not provided at this location'
                ]
            ],403);
        }

        return response()->json($slots);
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

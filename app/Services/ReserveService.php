<?php

namespace App\Services;

use App\Events\ServiceApplicationBooked;
use App\Http\Resources\ReserveResource;
use App\Lib\Utils;
use App\Models\Consumer;
use App\Models\Reserve;
use App\Models\ServiceApplicationPlace;
use App\Traits\ResponseTemplate;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use App\Exceptions\PreventUserToReserveTwiceWithinADayException;

class ReserveService
{
    use ResponseTemplate;
    private BookingService $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function set($request): object
    {

        try{
            $number_of_bookable_for_slot = $this->bookingService->number_of_bookable_for_slot($request->service_application_place_id,$request->from,$request->to);
//            return response()->json($number_of_bookable_for_slot);
            if (!$number_of_bookable_for_slot) {
                $this->setStatus(403);
                $this->setErrors([
                    'message' => 'Requested reservation cannot be made.
                               reasons :
                               This slot may already be reserved.
                               or the operator is not available,
                               please check the scheduling again and then apply'
                ]);
            } else {
                $serviceApplication = ServiceApplicationPlace::find($request->service_application_place_id)->serviceApplication;
                $price = $serviceApplication->price ?? $serviceApplication->service->default_price;
                $consumerId = $this->getConsumerId($request->consumer_id,Utils::getUserId());

                $reserve = Reserve::create([
                    'consumer_id' => $consumerId,
                    'service_application_place_id' => $request->service_application_place_id,
                    'operator_id' => $serviceApplication->operator_id,
                    'service_model_item_id' => $request->service_model_item_id,
                    'amount' => $request->amount ?? $price,
                    'currency' => $request->currency ?? 'IR-RIAL',
                    'from' =>  Carbon::createFromFormat('Y-m-d H:i:s', $request->from.":00")->timestamp,
                    'to' =>  Carbon::createFromFormat('Y-m-d H:i:s', $request->to.":00")->timestamp,
                ]);
                event(new ServiceApplicationBooked($reserve));
                $this->setData(new ReserveResource($reserve));
                $this->setStatus(201);
            }
        }catch (\Exception $exception){
            $this->setStatus(500);
            $this->setErrors([
                'message' => $exception->getMessage(),
            ]);
        }

        return $this->response();
    }

    public function PreventUserToReserveTwiceWithinADay($request)
    {

        $operator_id = ServiceApplicationPlace::find($request->input('service_application_place_id'))->serviceApplication->operator_id;
        $reserve_date_request = (new Carbon((new Carbon($request->from))->toDateString()." 00:00:00"))->getTimestamp();
        $LastReservedFromTheSameOperator = Reserve::where('consumer_id', $request->consumer_id)
            ->where('operator_id', $operator_id)
            ->where('from','>',$reserve_date_request)
            ->exists();
        if($LastReservedFromTheSameOperator){
           throw new PreventUserToReserveTwiceWithinADayException();
        }
    }

    private function getConsumerId($requestConsumerId,$userId)
    {
        if(empty($requestConsumerId))
        {
            return Consumer::query()->where('user_id',$userId)->first()->id;
        }
        else{
            return $requestConsumerId;
        }

    }
}

<?php

namespace App\Listeners;

use App\Jobs\SendNewReserveToCollectionJob;
use App\Models\Operator;
use App\Models\Reserve;
use App\Models\ServiceRequest;
use App\Models\UserCollection;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;
use App\Lib\Http\Request as CustomRequest;

class SendNewReserveToCollectionListener
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $reserve = $event->reserve;
        $serviceRequest = ServiceRequest::where('consumer_id',$reserve->consumer_id)
                ->where('service_model_item_id',$reserve->service_model_item_id)
                ->where('status','PENDING')->first();
        $serviceRequest = ServiceRequest::firstOrCreate([
            'consumer_id' => $reserve->consumer_id,
            'service_model_item_id' => $reserve->service_model_item_id,
            'status' => 'PENDING',
        ],[
            'consumer_id' => $reserve->consumer_id,
            'operator_id' => $reserve->operator_id,
            'service_model_item_id' => $reserve->service_model_item_id,
        ]);
        $serviceRequest->status = 'ACCEPT';
        $serviceRequest->accepted_by = $reserve->operator_id;
        $serviceRequest->accepted_at = Carbon::now();
        $serviceRequest->save();

        $userCollectionId = Operator::find($reserve->operator_id)->user_collection_id;
        $domain = UserCollection::find($userCollectionId)->domain;
        SendNewReserveToCollectionJob::dispatch([
            'booking_id' => $reserve->id,
            'consumer_id' => $reserve->consumer_id,
            'payment_status' => $reserve->payment_status,
            'status' => $reserve->status,
            'amount' => $reserve->amount,
            'currency' => $reserve->currency,
            'from' => $reserve->from,
            'to' => $reserve->to,
            'requested_by' => $serviceRequest->operator_id,
            'service_request_id' => $serviceRequest->id,
            'place' => $reserve->serviceApplicationPlace,
            'address' => $reserve->serviceApplicationPlace->address,
            'service_request_type' => $serviceRequest->serviceModelItem->serviceModel->serviceCategory->type,
            'service_model_item' => $serviceRequest->serviceModelItem,
            'service_model' => $reserve->serviceModelItem->serviceModel,
            'accepted_by' => $reserve->operator_id,
            'domain' => $domain
        ])->onQueue('default');

    }
}

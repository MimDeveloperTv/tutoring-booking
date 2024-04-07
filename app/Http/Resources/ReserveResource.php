<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Reserve */
class ReserveResource extends JsonResource
{
    public function toArray(Request $request)
    {
        $currency = [
            'IR-RIAL' => 'ريال',
            'US-DOLLAR' => '$'
        ];
        return [
            'id' => $this->id,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'amount' => $this->amount,
            'currency' => $currency[$this->currency],
            'from' => Carbon::createFromTimestamp( $this->from,'UTC')->format('Y-m-d H:i'),
            'to' => Carbon::createFromTimestamp( $this->to,'UTC')->format('Y-m-d H:i'),
            'created_at' => $this->created_at->format('Y-m-d H:i'),
//            'updated_at' => $this->updated_at,
            'consumer' => [
                'id' => $this->consumer->id,
                'name' => $this->consumer->fullname,
                'avatar' => $this->consumer->avatar,
                'phone' => '09364587562'
            ],
            'operator' => [
                'id' => $this->operator->id,
                'name' =>$this->operator->fullname,
                'avatar' => $this->operator->avatar
            ],
            'service_name' => $this->serviceApplicationPlace->serviceApplication->service->serviceModel->name,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ServiceRequest */
class ServiceRequestListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'item' => [
                'id' => $this->serviceModelItem->id,
                'name' => $this->serviceModelItem->serviceModel->name." - ".$this->serviceModelItem->label
            ],
            'visibility' => $this->visibility,
            'status' => $this->status,
            'accepted_at' => $this->accepted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'consumer' => [
                'id' => $this->consumer->id,
                'name' => $this->consumer->fullname,
                'avatar' => $this->consumer->avatar,
                'phone' => '09364587562'
            ],
            'functor' => new OperatorResource($this->functor),
            'operator' => new OperatorResource($this->operator),
//            'serviceModel' => new ServiceModelResource($this->serviceModelItem->serviceModel),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ServiceModelItem */
class OperatorServiceModelItemListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'price' => $this->serviceModel->services[0]->serviceApplications[0]->price
        ];
    }
}

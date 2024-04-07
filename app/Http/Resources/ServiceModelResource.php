<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ServiceModel */
class ServiceModelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'condition' => $this->condition,
            'isActive' => $this->isActive,
            'items' => $this->serviceModelItems->map(function ($item){
                return [
                    'id' => $item->id,
                    'label' => $item->label
                ];
            }),
        ];
    }
}

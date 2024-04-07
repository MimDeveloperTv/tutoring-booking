<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Service */
class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_collection_id' => $this->user_collection_id,
            'form_id' => $this->form_id,
            'default_price' => $this->default_price,
            'default_duration' => $this->default_duration,
            'default_break' => $this->default_break,
            'default_capacity' => $this->default_capacity,
            'service_applications_count' => $this->service_applications_count,
            'name' => $this->service_model_id,
        ];
    }
}

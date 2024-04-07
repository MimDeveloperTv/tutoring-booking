<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceApplicationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'operator_id' => $this->operator_id,
            'service' => [
                'id' => $this->service_id,
                'name' => $this->service->serviceModel->name
            ],
            'form_id' => $this->form_id ?? $this->service->form_id,
            'price' => $this->price ?? $this->service->default_price,
            'duration' => $this->duration ?? $this->service->default_duration,
            'break' => $this->break ?? $this->service->default_break,
            'capacity' => $this->capacity ?? $this->service->default_capacity,
        ];
    }
}

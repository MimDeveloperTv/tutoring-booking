<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchedulingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'service_application_id' => $this->service_application_id,
            'service_id' => $this->serviceApplication->service_id,
            'serviceName' => $this->serviceApplication->service->serviceModel->name,
            'place' => [
                'id' => $this->serviceApplicationPlace->id,
                'address' => $this->serviceApplicationPlace->address
            ],
            'weekday' => $this->weekday,
            'from' => sprintf('%02d:%02d', intval($this->from/60),($this->from % 60)),
            'to' => sprintf('%02d:%02d', intval($this->to/60),($this->to % 60)),
        ];
    }
}

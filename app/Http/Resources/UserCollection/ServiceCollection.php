<?php

namespace App\Http\Resources\UserCollection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCollection extends JsonResource
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
            'form_id' => $this->form_id,
            'name' => $this->serviceModel->name,
            'price' => $this->default_price,
            'duration' => $this->default_duration,
            'break' => $this->default_break,
            'capacity' => $this->default_capacity
        ];
    }
}

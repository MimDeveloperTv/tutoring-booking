<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchedulingCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'saturday' => isset($this['0']) ? SchedulingResource::collection($this['0']) : null,
            'sunday' => isset($this['1']) ? SchedulingResource::collection($this['1']) : null,
            'monday' => isset($this['2']) ? SchedulingResource::collection($this['2']) : null,
            'tuesday' => isset($this['3']) ? SchedulingResource::collection($this['3']) : null,
            'wednesday' => isset($this['4']) ? SchedulingResource::collection($this['4']) : null,
            'turseday' => isset($this['5']) ? SchedulingResource::collection($this['5']) : null,
            'friday' => isset($this['6']) ? SchedulingResource::collection($this['6']) : null,
        ];
        
    }
}

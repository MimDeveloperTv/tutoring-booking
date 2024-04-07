<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Reserve */
class ReserveCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => ReserveResource::collection($this->collection),
            'total' => $this->total(),
            'per_page' => $this->perPage(),
            'last_page' => $this->lastPage(),
            'current_page' => $this->currentPage(),
        ];
    }
}

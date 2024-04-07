<?php

namespace App\Services;

use App\Http\Resources\ServiceModelResource;
use App\Models\ServiceModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceModelService
{
    public function all() : ResourceCollection
    {
        return ServiceModelResource::collection(ServiceModel::all());
    }
}

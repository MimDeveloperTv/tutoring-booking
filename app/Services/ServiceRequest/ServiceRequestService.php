<?php

namespace App\Services\ServiceRequest;

use App\Http\Resources\ServiceRequestListResource;
use App\Models\Consumer;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Collection;

class ServiceRequestService
{

    public function get($flag,$collection_id,$consumer_id)
    {
        $serviceRequests = match ($flag) {
            'collection' => ServiceRequest::allowed($collection_id)->get(),
            'consumer' => Consumer::find($consumer_id)->serviceRequests,
            default => null,
        };
        return ServiceRequestListResource::collection($serviceRequests);
    }

    public function set(string $consumer_id,string $operator_id,int $service_model_item_id) : ServiceRequest
    {
        return ServiceRequest::create([
            'consumer_id' => $consumer_id,
            'operator_id' => $operator_id,
            'service_model_item_id' => $service_model_item_id,
        ]);
    }
}

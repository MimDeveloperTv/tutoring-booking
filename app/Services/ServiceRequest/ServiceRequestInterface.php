<?php

namespace App\Services\ServiceRequest;

use Illuminate\Database\Eloquent\Collection;

interface ServiceRequestInterface
{
    public function get(string $flag,string $collection_id,string $consumer_id);
}

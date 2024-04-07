<?php

namespace App\Http\Controllers;

use App\Services\ServiceRequest\ServiceRequestService;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    use ResponseTemplate;
    protected ServiceRequestService $serviceRequestService;
    public function __construct(ServiceRequestService $serviceRequestService)
    {
        $this->serviceRequestService = $serviceRequestService;
    }

    public function index(Request $request)
    {
        try {
            $this->setData($this->serviceRequestService->get($request->flag,$request->user_collection_id,$request->consumer_id));
        }catch (\Exception $exception)
        {
            $this->setErrors($exception->getMessage());
            $this->setStatus(459);
        }

        return $this->response();
    }

    public function store(Request $request)
    {
        $request->validate([
            'consumer_id' => 'required',
            'service_model_item_id' => 'required'
        ]);
        try {
           $this->setData($this->serviceRequestService->set($request->consumer_id,auth('user')->user()->operator->id,$request->service_model_item_id));
        }catch (\Exception $exception)
        {
            $this->setErrors($exception->getMessage());
            $this->setStatus(459);
        }
        return $this->response();
    }
}

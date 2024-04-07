<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceApplicationCollection;
use App\Http\Resources\ServiceApplicationResource;
use App\Models\Service;
use App\Models\ServiceApplication;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class ServiceApplicationController extends Controller
{
    use ResponseTemplate;
    public function index(Request $request,string $userId)
    {
        $operatorId = $userId;
        $serviceApplications = ServiceApplication::where('operator_id',$operatorId)->paginate($request->per_page ?? 5);
        $this->setData(ServiceApplicationCollection::collection($serviceApplications));
        return $this->response();
    }
    public function store(Request $request,string $userId)
    {
        $service_id = $request->service_id;
        $operator_id = $userId;
        $service = Service::where('id',$service_id)->whereDoesntHave('serviceApplications',function($query)use($operator_id){
             return $query->where('operator_id',$operator_id);
        })->first();
        try {
        if($service)
        {
            $serviceApplication = $service->serviceApplications()->create([
                'operator_id' => $operator_id,
                'form_id' => $request->form_id,
                'price' => $request->price,
                'duration' => $request->duration,
                'break' => $request->break,
                'capacity' => $request->capacity,
                'online' => $request->online ? $request->online : false,
                'onAnotherSite' => $request->onAnotherSite ? $request->onAnotherSite : false,
                'isActive' => $request->isActive ? $request->isActive : true,
            ]);

            $this->setData(new ServiceApplicationResource($serviceApplication));
        }
        else
        {
            $this->setStatus(422);
            $this->setErrors(['message' => 'ERROR! selected service not found! It may have been deleted or already used.']);
        }
        } catch (\Throwable $th) {
             $this->setErrors(['message' => 'Programmer ERROR! :'.$th->getMessage()]);
             $this->setStatus(500);
        }
        return $this->response();
    }
}

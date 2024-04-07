<?php

namespace App\Http\Controllers;

use App\Models\ServiceApplication;
use App\Models\ServiceApplicationPlace;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class ServiceApplicationPlaceController extends Controller
{
    use ResponseTemplate;
    public function store(Request $request,string $userId,string $applicationId)
    {
        $serviceId = $applicationId;
        $address_id = $request->address_id;

        $applicationService = ServiceApplication::query()
            ->find($serviceId)
            ->whereDoesntHave('places',function($query)use($address_id){
            return $query->where('address_id',$address_id);
        })->first();

        try {
            if($applicationService)
        {
            $applicationPlace = $applicationService->places()->create([
                'address_id' => $address_id,
                'isActive' => $request->isActive ?? true
            ]);
            $this->setData($applicationPlace);
        }
        else
        {
            $this->setStatus(422);
            $this->setErrors(['message' => 'ERROR! the selected address already assigned to the service.']);
        }
        } catch (\Throwable $th) {
             $this->setErrors(['message' => 'Programmer ERROR! :'.$th->getMessage()]);
             $this->setStatus(500);
        }
        return $this->response();
    }

    public function index(Request $request,string $userId,string $applicationId)
    {
        $operatorId = $userId;
        $serviceId = $applicationId;

        $applicationPlaces = ServiceApplication::query()
            ->where('operator_id',$operatorId)
            ->where('service_id',$serviceId)
            ->first()
            ->places;
        $this->setData($applicationPlaces);
        return $this->response();
    }
}

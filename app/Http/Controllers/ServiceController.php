<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection\ServiceResource;
use App\Http\Resources\UserCollection\ServiceCollection;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceModel;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ResponseTemplate;
    public function index(Request $request, $user_collection_id)
    {

//            if($type == 'all')
//            {
                $services = Service::where('user_collection_id', $user_collection_id)->paginate($request->per_page ?? 5);
//            }
//            else
//            {
//                $services = Service::where('user_collection_id', $user_collection_id)->whereHas('serviceModel', function ($query) use ($type) {
//                    return $query->whereHas('serviceCategory', function ($query) use ($type) {
//                        return $query->where('type', $type);
//                    });
//                })->paginate($request->per_page ?? 5);
//            }
            $this->setData(ServiceCollection::collection($services));


        return $this->response();
    }

    public function store(Request $request, $user_collection_id)
    {
        $service_model_id = $request->service_model_id;
        $serviceModel = ServiceModel::where('id', $service_model_id)->whereDoesntHave('services', function ($query) use ($user_collection_id) {
            return $query->where('user_collection_id', $user_collection_id);
        })->first();
        try {
            if ($serviceModel) {
                $service = $serviceModel->services()->create([
                    'user_collection_id' => $user_collection_id,
                    'form_id' => $request->form_id,
                    'default_price' => $request->default_price,
                    'default_duration' => $request->default_duration,
                    'default_break' => $request->default_break,
                    'default_capacity' => $request->default_capacity,
                ]);

                $this->setData(new ServiceResource($service));
            } else {
                $this->setStatus(422);
                $this->setErrors(['message' => 'ERROR! selected service not found! It may have been deleted or already used.']);
            }
        } catch (\Throwable $th) {
            $this->setErrors(['message' => 'Programmer ERROR! :' . $th->getMessage()]);
            $this->setStatus(500);
        }
        return $this->response();
    }
}

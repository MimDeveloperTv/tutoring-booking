<?php

namespace App\Http\Controllers;

use App\Http\Resources\OperatorResource;
use App\Http\Resources\PlaceAddressResource;
use App\Models\Operator;
use App\Models\ServiceApplicationPlace;
use App\Traits\ResponseTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Service;

class OperatorAvailabilityController extends Controller
{
    use ResponseTemplate;
    public function operators(Request $request,$serviceId)
    {
        $operators = Operator::whereHas('serviceApplications',function($query)use($serviceId){
            return $query->where('service_id',$serviceId);
        })->get();

        $this->setData(OperatorResource::collection($operators));
        return $this->response();
    }

    public function operatorsOld(Request $request)
    {
//        $item_id = $request->item_id;
//        $user_collection_id = $request->user_collection_id;
//        if($request->has('service_id'))
//            $service_id = $request->service_id;
//        else
//            $service_id = Service::where('user_collection_id', $user_collection_id)->whereHas('serviceModel',function (Builder $builder)use($item_id){
//                return $builder->whereHas('serviceModelItems',function (Builder $builder)use ($item_id){
//                    return $builder->where('id',$item_id);
//                });
//            })->first()->id ?? null;
//        $operators = Operator::whereHas('serviceApplications',function($query)use($service_id){
//            return $query->where('service_id',$service_id);
//        })->get();
//
//        $this->setData(OperatorResource::collection($operators));
//        return $this->response();
    }
}

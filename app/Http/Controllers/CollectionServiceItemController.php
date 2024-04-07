<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceModelItemListResource;
use App\Models\ServiceModelItem;
use App\Traits\ResponseTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CollectionServiceItemController extends Controller
{
    use ResponseTemplate;
    public function appointable(Request $request,$collection_id)
    {
        $consumer_id = $request->consumer_id;
        $items = ServiceModelItem::whereHas('serviceModel',function (Builder $serviceModel)use ($consumer_id,$collection_id){
            return $serviceModel->whereHas('services',function (Builder $services)use ($consumer_id,$collection_id){
                return $services->where('user_collection_id',$collection_id);
            });
        })->where(function (Builder $query)use($consumer_id,$collection_id){
            return $query->whereHas('serviceModel',function (Builder $serviceModel){
                return $serviceModel->where('non_prescription',1);
            })->orWhereHas('serviceRequest',function (Builder $serviceRequest)use ($consumer_id){
                return $serviceRequest->where('consumer_id',$consumer_id)->where('status','PENDING');
            });
        })->get();
        $this->setData(ServiceModelItemListResource::collection($items));
        return $this->response();
    }
}

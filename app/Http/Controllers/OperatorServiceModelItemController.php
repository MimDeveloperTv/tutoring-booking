<?php

namespace App\Http\Controllers;

use App\Http\Resources\OperatorServiceModelItemListResource;
use App\Models\ServiceModelItem;
use App\Traits\ResponseTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class OperatorServiceModelItemController extends Controller
{
    use ResponseTemplate;

    public function index(Request $request)
    {

        try {
            $operator_id = $request->operator_id;
            $items = ServiceModelItem::whereHas('serviceModel',function (Builder $serviceModel)use ($operator_id){
                return $serviceModel->whereHas('services',function (Builder $services)use ($operator_id){
                    return $services->whereHas('serviceApplications',function (Builder $serviceApplication)use ($operator_id){
                        return $serviceApplication->where('operator_id',$operator_id);
                    });
                });
            })->with('serviceModel',function (BelongsTo $serviceModel)use($operator_id){
                return $serviceModel->with('services',function (HasMany $services)use ($operator_id){
                    return $services->whereHas('serviceApplications',function (Builder $serviceApplication)use ($operator_id){
                        return $serviceApplication->where('operator_id',$operator_id);
                    })->with('serviceApplications',function (HasMany $serviceApplication)use ($operator_id){
                            return $serviceApplication->where('operator_id',$operator_id);
                    });
                });
            })->get();
            $this->setData(OperatorServiceModelItemListResource::collection($items));
        }catch (\Exception $exception)
        {
            $this->setErrors($exception->getMessage());
            $this->setStatus(459);
        }
        return $this->response();
    }
}

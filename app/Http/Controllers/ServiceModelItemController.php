<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceModelResource;
use App\Models\ServiceModel;
use Illuminate\Http\Request;
use App\Models\ServiceModelItem;
use App\Http\Resources\ListServiceModelResource;
use App\Http\Resources\ServiceModelItemResource;
use App\Services\PreventServiceModelSystemModification;
use App\Http\Requests\ServiceModelItemRequest;
class ServiceModelItemController extends Controller
{
    public function index()
    {
        $ServiceModelItems = ServiceModelItem::all();

        $this->setData(ListServiceModelResource::collection($ServiceModelItems));

        return $this->response();
    }

    public function show($id)
    {
        $ServiceModelItem = ServiceModelItem::findOrFail($id);

        $this->setData(new ServiceModelItemResource($ServiceModelItem));

        return $this->response();

    }

    public function store(ServiceModelItemRequest $request)
    {
        $serviceModelItem = ServiceModelItem::create([
            "service_model_id" => $request->service_model_id,
            "label" => $request->label
        ]);

        $this->setData(new ServiceModelItemResource($serviceModelItem));

        return $this->response();
    }

    public function update(ServiceModelItemRequest $request,$id)
    {
        $serviceModelItem = ServiceModelItem::find($id);

        PreventServiceModelSystemModification::handle($serviceModelItem);

        $serviceModelItem->update([
            "service_model_id" => $request->service_model_id,
            "label" => $request->label
        ]);

        $serviceModelItem = ServiceModelItem::find($id);

        $this->setData(new ServiceModelItemResource($serviceModelItem));

        return $this->response();

    }

    public function destroy($id)
    {

        $serviceModelItem = ServiceModelItem::find($id);

        PreventServiceModelSystemModification::handle($serviceModelItem);

        ServiceModelItem::destroy($id);

        $this->setData(["message" => "Item successfully Deleted"])
        ->setStatus(202);
        return $this->response();

    }
}

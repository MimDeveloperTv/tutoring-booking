<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceModelResource;
use App\Models\ServiceCategory;
use App\Models\ServiceModel;
use App\Services\ServiceCategoryService;
use App\Services\ServiceModelService;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceCategorResource;
use App\Http\Resources\ListServiceModelResource;
use App\Http\Requests\ServiceModelRequest;

class ServiceModelController extends Controller
{
    use ResponseTemplate;
    private ServiceCategoryService $serviceCategoryService;
    private ServiceModelService $serviceModelService;
    public function __construct(ServiceCategoryService $serviceCategoryService)
    {
        $this->serviceCategoryService = $serviceCategoryService;
        $this->serviceModelService =  new ServiceModelService();
    }

    public function index(Request $request)
    {
         if($request->has('flag') && $request->flag == 'all')
         {
              $this->setData($this->serviceModelService->all());
         }
         else
         {
             if(is_null($request->category_id))
                 $this->setData($this->serviceCategoryService->getTreeViewFromTop());
             else
                 $this->setData($this->serviceCategoryService->getThreeFromNode($request->category_id));
         }
         return $this->response();
    }

    public function store(ServiceModelRequest $request)
    {

       $serviceModel =  ServiceModel::create([
            'service_category_id' => $request->service_category_id,
            'name' => $request->name,
            'description' => $request->description,
            'condition' => $request->condition,
            'calculation' => $request->calculation,
            'isActive' => $request->isActive,
            'items' => $request->items,
            'are_items_independent' => $request->are_items_independent,
            'non_prescription' => $request->non_prescription,
            'form_id' => $request->form_id,
        ]);

       $this->setData(new ListServiceModelResource($serviceModel));

       return $this->response();
    }

    public function show($id)
    {
        $serviceCategory = ServiceModel::find($id);

        $this->setData(new ServiceCategorResource($serviceCategory));

        return $this->response();
    }

    public function update(ServiceModelRequest $request,$id)
    {

       $serviceModel = ServiceModel::find($id);
       if($serviceModel->created_by === "SYSTEM") {
           $this->setData(["message" => "You are not allowed to Delete System Services"])
               ->setStatus(403);
           return $this->response();
       }
           $serviceModel->update([
               'service_category_id' => $request->service_category_id,
               'name' => $request->name,
               'description' => $request->description,
               'condition' => $request->condition,
               'calculation' => $request->calculation,
               'isActive' => $request->isActive,
               'items' => $request->items,
               'are_items_independent' => $request->are_items_independent,
               'non_prescription' => $request->non_prescription,
               'form_id' => $request->form_id,
           ]);



       $result = ServiceModel::find($id);

       $this->setData(new ServiceModelResource($result));

       return $this->response();

    }

    public function destroy($id)
    {

        ServiceModel::destroy($id);

        $this->setData(['message' => 'success'])->setStatus(204);

        return $this->response();

    }
}

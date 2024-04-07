<?php

namespace App\Http\Controllers\UserCollection;

use App\DataTransferObjects\AddressDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCollectionAddressRequest;
use App\Http\Resources\AddressResource;
use App\Services\AddressService;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ResponseTemplate;
    protected AddressService $addressService;
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index(Request $request)
    {
        $this->setData(AddressResource::collection($this->addressService->getAll($request->user_collection_id)));
         return $this->response();
    }

    public function store(StoreCollectionAddressRequest $request)
    {
         $addressDTO = new AddressDTO(
             addressable_id: $request->input('user_collection_id'),
             addressable_type: "App\Models\UserCollection",
             title: $request->input('title'),
             latitude: $request->input('latitude'),
             longitude: $request->input('longitude'),
             description: $request->input('description'),
             phone: $request->input('phone'),
         );

         if($address = $this->addressService->save($addressDTO)){
             $this->setData(new AddressResource($address));
             $this->setStatus(201);
         } else {
             $this->setErrors(['message' => 'ERROR! booking server error!']);
             $this->setStatus(429);
         }

         return $this->response();
    }
}

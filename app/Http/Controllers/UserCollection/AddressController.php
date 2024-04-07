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

    public function index(Request $request, $user_collection_id)
    {
        $collection = $this->addressService->getAll($user_collection_id);
        $this->setData(AddressResource::collection($collection));
         return $this->response();
    }

    public function store(StoreCollectionAddressRequest $request, $user_collection_id)
    {
         $addressDTO = new AddressDTO(
             addressable_id: $user_collection_id,
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

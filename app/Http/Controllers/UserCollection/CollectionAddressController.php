<?php

namespace App\Http\Controllers\UserCollection;

use App\DataTransferObjects\AddressDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCollectionAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class CollectionAddressController extends Controller
{
    use ResponseTemplate;
    public function __construct()
    {}

    public function index(Request $request, $user_collection_id)
    {
        $addressType = 'App\Models\UserCollection';

        $address = Address::query()
            ->where('addressable_id',$user_collection_id)
            ->where('addressable_type',$addressType)
            ->get();

        $this->setData(AddressResource::collection($address));
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

         if($address = $this->save($addressDTO)){
             $this->setData(new AddressResource($address));
             $this->setStatus(201);
         } else {
             $this->setErrors(['message' => 'ERROR! booking server error!']);
             $this->setStatus(429);
         }

         return $this->response();
    }

    public function save(AddressDTO $addressData):Address
    {
        return  Address::create([
            'addressable_type' => $addressData->addressable_type,
            'addressable_id' => $addressData->addressable_id,
            'title' => $addressData->title,
            'latitude' => $addressData->latitude,
            'longitude' => $addressData->longitude,
            'description' => $addressData->description,
            'phone' => $addressData->phone
        ]);
    }
}

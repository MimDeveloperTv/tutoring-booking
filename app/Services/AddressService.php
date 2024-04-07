<?php

namespace App\Services;

use App\DataTransferObjects\AddressDTO;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressService
{
     public function getAll($user_collection_id) : Collection
     {
         return Address::query()
             ->where('addressable_id',$user_collection_id,)
             ->where('addressable_type','App\Models\UserCollection')
             ->get();
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

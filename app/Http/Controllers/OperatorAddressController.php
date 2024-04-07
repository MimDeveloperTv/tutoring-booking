<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressCollection;
use App\Models\Address;
use App\Models\Operator;
use App\Models\User;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;

class OperatorAddressController extends Controller
{
    use ResponseTemplate;

    public function index(Request $request,string $userId)
    {
        $addressType = 'App\Models\User';

        $addresses = Address::query()
            ->where('addressable_id',$userId)
            ->where('addressable_type',$addressType)
            ->get();

        /* Disable load both of Address in This Route
        $addresses = Address::query()
            ->where('addressable_id',$userId)
               ->orWhere('addressable_id',$request->user_collection_id)
            ->get();
        */

        $this->setData(AddressCollection::collection($addresses));
        return $this->response();
    }

    public function store(Request $request,string $userId)
    {
        $request->validate([
            'title' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            'phone' => 'required',
        ]);

        $user = User::query()->find($userId);
        /* @var \App\Models\User $user */

        $address =  $user->addresses()->create([
            'title' => $request->title,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'phone' => $request->phone
        ]);
        $this->setData(new AddressCollection($address));
        return $this->response();
    }

}

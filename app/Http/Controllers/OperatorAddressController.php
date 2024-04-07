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

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            'phone' => 'required',
        ]);
        $user = User::find($request->user_id);
        $address =  User::find($request->user_id)->addresses()->create([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'phone' => $request->phone
        ]);
        $this->setData(new AddressCollection($address));
        return $this->response();
    }
    public function index(Request $request)
    {
        $addresses = Address::where('addressable_id',$request->user_id)
        ->orWhere('addressable_id',$request->user_collection_id)->get();
        $this->setData(AddressCollection::collection($addresses));
        return $this->response();
    }
}

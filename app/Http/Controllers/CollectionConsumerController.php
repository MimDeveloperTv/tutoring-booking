<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Operator;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;
use App\Lib\Http\Request as CustomRequest;
class CollectionConsumerController extends Controller
{
    use ResponseTemplate;

    public function store(Request $request,$userCollectionId)
    {
            try {
                $consumer = Consumer::where('user_id',$request->user_id)->first();
                if(!$consumer)
                    $consumer = Consumer::create([
                    'user_collection_id' => $userCollectionId,
                    'user_id' => $request->user_id,
                    'fullname' => $request->fullname,
                    'avatar' => $request->avatar
                  ]);
                 if($consumer)
                 {
                    $this->setStatus(201);
                    $this->setData($consumer);
                 }
             } catch (\Throwable $th) {
                 $this->setStatus(500);
                 $this->setErrors($th->getMessage());
             }

         return $this->response();
    }
}

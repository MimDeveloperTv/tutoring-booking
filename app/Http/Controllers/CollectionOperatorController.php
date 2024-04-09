<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;
use App\Lib\Http\Request as CustomRequest;
class CollectionOperatorController extends Controller
{
    use ResponseTemplate;

    public function store(Request $request,$userCollectionId)
    {
        try {
            try {
                $operator = Operator::where('user_collection_id',$userCollectionId)
                    ->where('user_id',$request->user_id)
                    ->first();
                if(!$operator)
                {
                    $operator = Operator::updateOrCreate(
                        [
                            'user_id' => $request->user_id
                        ],[
                        'user_collection_id' => $userCollectionId,
                        'user_id' => $request->user_id,
                        'fullname' => $request->fullname,
                        'avatar' => $request->avatar
                    ]);
                }

                 if($operator)
                 {
                    $this->setStatus(201);
                    $this->setData($operator);
                 }
             } catch (\Throwable $th) {
                 $this->setStatus(500);
                 $this->setErrors($th->getMessage());
             }

        } catch (\Throwable $th) {
            $this->setStatus(400);
            $this->setErrors($th->getMessage());
        }

         return $this->response();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Traits\ResponseTemplate;
use Illuminate\Http\Request;
use App\Lib\Http\Request as CustomRequest;
class CollectionOperatorController extends Controller
{
    use ResponseTemplate;
    public function index(Request $request,$collection_id)
    {

    }

    public function store(Request $request)
    {
        $iam_api_key = $request->header('api-key');

        try {
            $iam_response = CustomRequest::get([
                'authorization' => 'Bearer '.$iam_api_key
            ],[

            ],'iam','/collections/auth');
            $collection_id = json_decode($iam_response->body())->data->id;
            try {
                $operator = Operator::where('user_collection_id',$collection_id)
                    ->where('user_id',$request->user_id)
                    ->first();
                if(!$operator)
                {
                    $operator = Operator::updateOrCreate(
                        [
                            'user_id' => $request->user_id
                        ],[
                        'user_collection_id' => $collection_id,
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

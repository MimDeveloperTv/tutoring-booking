<?php

namespace App\Services;

use App\Traits\ResponseTemplate;
use App\Exceptions\PreventServiceModelSystemModificationException;

class PreventServiceModelSystemModification
{
use ResponseTemplate;
    public static function handle($serviceModelItem)
    {

        if($serviceModelItem->serviceModel->created_by == "SYSTEM"){
//            dd($serviceModelItem->serviceModel->created_by);
//            (new self)->setData(['message' => 'You are not allowed to Delete System Services'])
//                ->setStatus(403);
//            return (new self)->response();
            throw new PreventServiceModelSystemModificationException();
        }
    }

}

<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use App\Traits\ResponseTemplate;
use Exception;


class PreventUserToReserveTwiceWithinADayException extends Exception
{
    use ResponseTemplate;

    public function render(): JsonResponse
    {
        $this->setData(['message' => 'You Cant Reserve The Same Doctor Within a day '])
            ->setStatus(403);
        return $this->response();
    }
}

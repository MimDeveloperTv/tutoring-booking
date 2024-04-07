<?php

namespace App\Traits;
use Illuminate\Http\JsonResponse;
trait ResponseTemplate
{
    private $data = [];
    private $status = 200;
    private $errors = [];

    public function setStatus(int $status) : self
    {
         $this->status = $status;
         return $this;
    }

    public function setData($data) : self
    {
        $this->data = $data;
        return $this;
    }

    public function setErrors($errors) : self
    {
        $this->errors = $errors;
        return $this;
    }

    public function response(string $platform = 'web') : JsonResponse
    {

        switch ($platform) {
            case 'app':
                return response()->json(['data' => $this->data,'errors' => $this->errors,'status' => $this->status],$this->status);
                break;
            default:
                  return response()->json(['data' => $this->data,'errors' => $this->errors],$this->status);
                break;
        }
    }
}

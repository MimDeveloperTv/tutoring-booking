<?php

namespace App\Http\Controllers\Reserve;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reserve\UpdateRequest;
use App\Models\Reserve;
use App\Traits\ResponseTemplate;

class ReservePaymentController extends Controller
{
    use ResponseTemplate;
    public function update(UpdateRequest $request, $id)
    {
        try {
            Reserve::findOrFail($id)->update([
                'payment_status' => $request->input('payment_status')
            ]);
            return $this->response();
        }catch (\Exception $exception){
            $this->setErrors(['errors' => $exception->getMessage()]);
            $this->setStatus(500);
            return $this->response();
        }
    }
}

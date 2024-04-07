<?php

namespace App\Http\Controllers\Reserve;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reserve\UpdateStatusRequest;
use App\Models\Reserve;
use App\Traits\ResponseTemplate;

class ReserveStatusController extends Controller
{
    use ResponseTemplate;
    public function update(UpdateStatusRequest $request,$id)
    {
        try {
            Reserve::findOrFail($id)->update([
                'status' => $request->input('status')
            ]);
            return $this->response();
        }catch (\Exception $exception){
            $this->setErrors(['errors' => $exception->getMessage()]);
            $this->setStatus(500);
            return $this->response();
        }
    }
}

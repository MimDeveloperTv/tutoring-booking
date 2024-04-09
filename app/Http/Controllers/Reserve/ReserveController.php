<?php

namespace App\Http\Controllers\Reserve;

use App\Exceptions\PreventUserToReserveTwiceWithinADayException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reserve\UpdateRequest;
use App\Http\Resources\ReserveCollection;
use App\Http\Resources\ReserveResource;
use App\Models\Reserve;
use App\Models\ServiceApplicationPlace;
use App\Services\ReserveService;
use App\Traits\ResponseTemplate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    use ResponseTemplate;
     private ReserveService $reserveService;
     public function __construct(ReserveService $reserveService)
     {
         $this->reserveService = $reserveService;
     }

     public function store(Request $request)
     {
         $this->reserveService->PreventUserToReserveTwiceWithinADay($request);
         try {
             return $this->reserveService->set($request);
         }catch (\Exception $exception){
             return response()->json($exception->getMessage(),453);
         }
     }

     public function updateStatus(UpdateRequest $request, $id)
     {
         try {
             Reserve::findOrFail($id)->update([
                 'payment_status' => $request->input('payment_status'),
                 'status' => $request->input('status')
             ]);
             return $this->response();
         }catch (\Exception $exception){
             $this->setErrors(['errors' => $exception->getMessage()]);
             $this->setStatus(500);
             return $this->response();
         }
     }

     public function show(Request $request,$id)
     {
          $reserve = Reserve::find($id);
          $this->setData(new ReserveResource($reserve));
          return $this->response();
     }
}

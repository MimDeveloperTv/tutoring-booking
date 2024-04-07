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

     public function update(UpdateRequest $request, $id)
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

     public function getCollectionReserves(Request $request)
     {
         $user_collection_id = $request->user_collection_id;
         if ($request->flag == 'today')
         {
             $today = Carbon::now()->format('Y-m-d');
             $todayTimeStamp = Carbon::createFromFormat('Y-m-d H:i:s',$today." 00:00:00")->getTimestamp();
             $reserves = Reserve::whereHas('consumer',function (Builder $builder)use($user_collection_id){
                 return $builder->where('user_collection_id',$user_collection_id);
             })->whereBetween('from',[$todayTimeStamp,$todayTimeStamp+86400]);
         }
         else
         {
             $reserves = Reserve::whereHas('consumer',function (Builder $builder)use($user_collection_id){
                 return $builder->where('user_collection_id',$user_collection_id);
             });
         }
         $reserves = $reserves->when($request['consumer_name'],function ($query)use ($request){
             return $query->whereHas('consumer',function ($query)use ($request){
                 $query->where('fullname','LIKE','%'.$request->input('consumer_name').'%');
             });
         })->when($request['operator_name'],function ($query)use ($request){
             return $query->whereHas('operator',function ($query)use ($request){
                 $query->withTrashed()->where('fullname','LIKE','%'.$request->input('operator_name').'%');
             });
         })->when($request['payment_status'],function ($query)use ($request){
             return $query->where('payment_status',$request->input('payment_status'));
         })->when($request['status'],function ($query)use ($request){
             return $query->where('status',$request->input('status'));
         })->when($request['reserved_from'] && $request['reserved_to'],function ($query)use ($request){
             return $query->whereBetween('from',[
                 Carbon::createFromFormat('Y-m-d',$request->input('reserved_from'))->getTimestamp(),
                 Carbon::createFromFormat('Y-m-d',$request->input('reserved_to'))->getTimestamp()
             ]);
         })->when($request['amount_from'] && $request['amount_to'],function ($query)use ($request){
             return $query->whereBetween('amount',[$request->input('amount_from'),$request->input('amount_to')]);
         })->when($request['service_name'],function ($query)use ($request){
             return $query->whereHas('serviceApplicationPlace',function ($query)use ($request){
                 return $query->whereHas('serviceApplication',function ($query)use ($request){
                     return $query->whereHas('service',function ($query)use ($request){
                         return $query->whereHas('serviceModel',function ($query)use ($request){
                             return $query->where('name','LIKE','%'.$request->input('service_name').'%')
                                 ->orWhereHas('serviceModelItems',function ($query)use ($request){
                                   return $query->where('label','LIKE','%'.$request->input('service_name').'%');
                             });
                         });
                     });
                 });
             });
         })->orderBy('from', 'desc')->paginate($request->input('pagination') ?? 10);
         $this->setData(new ReserveCollection($reserves));
         return $this->response();
     }



     public function show(Request $request,$id)
     {
          $reserve = Reserve::find($id);
          $this->setData(new ReserveResource($reserve));
          return $this->response();
     }
}

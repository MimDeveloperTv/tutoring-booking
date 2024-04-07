<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CollectionConsumerController;
use App\Http\Controllers\CollectionOperatorController;
use App\Http\Controllers\ExceptionSchedulingController;
use App\Http\Controllers\OperatorAddressController;
use App\Http\Controllers\OperatorAvailabilityController;
use App\Http\Controllers\Reserve\ReserveController;
use App\Http\Controllers\ServiceApplicationController;
use App\Http\Controllers\ServiceApplicationPlaceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceModelController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\UserCollection\AddressController;
use App\Http\Controllers\WeeklySchedulingController;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceModelItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionServiceItemController;



Route::apiResource('category', CategoryController::class);
Route::apiResource('service-model-category', ServiceModelController::class);
Route::apiResource('service-model-item', ServiceModelItemController::class);

Route::get('collection/addresses',[AddressController::class,'index']);
Route::post('collection/addresses',[AddressController::class,'store']);
Route::get('collection/{collection_id}/services',[ServiceController::class,'index']);
Route::post('collection/{collection_id}/services',[ServiceController::class,'store']);
Route::get('collection/{collection_id}/appointable-items',[CollectionServiceItemController::class,'appointable']);

Route::post('/collections/operators',[CollectionOperatorController::class,'store']);
Route::post('/collections/consumers',[CollectionConsumerController::class,'store']);
Route::get('collections/services',[ServiceController::class,'index']);


Route::get('service-applications',[ServiceApplicationController::class,'index']);
Route::post('service-applications',[ServiceApplicationController::class,'store']);

Route::get('operator-service-model-items',[\App\Http\Controllers\OperatorServiceModelItemController::class,'index']);

Route::get('service-application-places',[ServiceApplicationPlaceController::class,'index']);
Route::post('service-application-places',[ServiceApplicationPlaceController::class,'store']);

Route::get('weekly-schedules',[WeeklySchedulingController::class,'index']);
Route::post('weekly-schedules',[WeeklySchedulingController::class,'store']);

Route::get('exception-schedules',[ExceptionSchedulingController::class,'index']);
Route::post('exception-schedules',[ExceptionSchedulingController::class,'store']);

Route::get('service-operators',[OperatorAvailabilityController::class,'operators']);

Route::get('service-operator-places',[OperatorAvailabilityController::class,'places']);
Route::post('operators/addresses',[OperatorAddressController::class,'store']);
Route::get('operators/addresses',[OperatorAddressController::class,'index']);

Route::get('service-application-place/slots',[BookingController::class,'slots']);


Route::get('services',[ServiceModelController::class,'index']);


Route::get('service-requests',[ServiceRequestController::class,'index']);
Route::post('service-requests',[ServiceRequestController::class,'store'])->middleware(['auth:user','user-has-model:operator']);



Route::post('/operators',function(Request $request){
    Operator::query()->create($request->only(['user_id' ]));
});

Route::get('/operators/{user_id}/services',function(Request $request){});



/* todo: this route is old and new implement in core service */
//Route::get('collection/appointments',[ReserveController::class,'getCollectionReserves']);

// todo: this route moved to core service and not need to booking service
Route::get('appointments/{id}',[ReserveController::class,'show']);


// todo: this method implement in core service and redirect core to booking api
Route::post('reserves',[ReserveController::class,'store']);


// todo: convert
// refactor one method to spilit method for update statuses
Route::put('appointments/{id}',[ReserveController::class,'update']);

//Route::patch('appointments/{id}/payment-status',[ReservePaymentController::class,'update']);
//Route::patch('appointments/{id}/status',[ReserveStatusController::class,'update']);
// end convert


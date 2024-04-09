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
use App\Http\Controllers\UserCollection\CollectionAddressController;
use App\Http\Controllers\WeeklySchedulingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceModelItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionServiceItemController;
use App\Http\Controllers\OperatorServiceModelItemController;

/* ----- Admin  Scope ------- */
Route::apiResource('services/category', CategoryController::class);
Route::apiResource('services/model', ServiceModelController::class);
Route::apiResource('services/item', ServiceModelItemController::class);
/* ----- Admin  Scope ------- */


/* ----- outside  Scope ------- */

Route::get('services/{serviceId}/operators',[OperatorAvailabilityController::class,'operators']);

Route::get('operators/{userId}/addresses',[OperatorAddressController::class,'index']);
Route::post('operators/{userId}/addresses',[OperatorAddressController::class,'store']);
Route::get('operators/{userId}/applications',[ServiceApplicationController::class,'index']);
Route::post('operators/{userId}/applications',[ServiceApplicationController::class,'store']);
Route::get('operators/{userId}/application-places/{applicationId}',[ServiceApplicationPlaceController::class,'index']);
Route::post('operators/{userId}/application-places/{applicationId}',[ServiceApplicationPlaceController::class,'store']);
Route::get('operators/{userId}/application-items/',[OperatorServiceModelItemController::class,'index']);

Route::get('collection/{collection_id}/addresses',[CollectionAddressController::class,'index']);
Route::post('collection/{collection_id}/addresses',[CollectionAddressController::class,'store']);
Route::get('collection/{collection_id}/services',[ServiceController::class,'index']);
Route::post('collection/{collection_id}/services',[ServiceController::class,'store']);
Route::get('collection/{collection_id}/appointable-items',[CollectionServiceItemController::class,'appointable']);
Route::post('/collection/{collection_id}/operators',[CollectionOperatorController::class,'store']);
Route::post('/collection/{collection_id}/consumers',[CollectionConsumerController::class,'store']);

Route::put('reserves/{id}/update-status',[ReserveController::class,'updateStatus']);
Route::post('reserves',[ReserveController::class,'store']);
Route::post('reserves/slots',[BookingController::class,'slots']);
Route::get('reserves/{id}',[ReserveController::class,'show']);

/* ----- outside  Scope ------- */



/* -- Not Refactored ------------------- */
Route::get('weekly-schedules',[WeeklySchedulingController::class,'index']);
Route::post('weekly-schedules',[WeeklySchedulingController::class,'store']);

Route::get('exception-schedules',[ExceptionSchedulingController::class,'index']);
Route::post('exception-schedules',[ExceptionSchedulingController::class,'store']);

Route::get('service-requests',[ServiceRequestController::class,'index']);
Route::post('service-requests',[ServiceRequestController::class,'store'])->middleware(['auth:user','user-has-model:operator']);

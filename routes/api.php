<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'depots'],function (){
    Route::post('/',[\App\Http\Controllers\DepotController::class,'store']);
    Route::get('/',[\App\Http\Controllers\DepotController::class,'getAll']);
});

Route::group(['prefix'=>'vehicles'],function (){
    Route::get('/',[\App\Http\Controllers\VehiclesController::class,'getAll']);
    Route::get('/available',[\App\Http\Controllers\VehiclesController::class,'getAvailableVehicles']);
    Route::post('/',[\App\Http\Controllers\VehiclesController::class,'store']);
    Route::post('/mark_loading',[\App\Http\Controllers\VehiclesController::class,'markVehicleLoading']);
    Route::post('/mark_on_transit',[\App\Http\Controllers\VehiclesController::class,'markVehicleOnTransit']);
    Route::post('/mark_available',[\App\Http\Controllers\VehiclesController::class,'markVehicleAvailable']);
    Route::put('/{id}',[\App\Http\Controllers\VehiclesController::class,'update']);
    Route::delete('/delete/{id}',[\App\Http\Controllers\VehiclesController::class,'destroy']);
});

Route::group(['prefix'=>'orders'],function (){
    Route::get('/',[\App\Http\Controllers\OrdersController::class,'getAll']);
    Route::get('/loading',[\App\Http\Controllers\OrdersController::class,'getLoadingOrders']);
    Route::get('/dispatched',[\App\Http\Controllers\OrdersController::class,'getDispatchedOrders']);
    Route::get('/pending',[\App\Http\Controllers\OrdersController::class,'getPendingOrders']);
    Route::post('/allocate',[\App\Http\Controllers\OrdersController::class,'allocate']);
    Route::post('/mark_order_dispatched',[\App\Http\Controllers\OrdersController::class,'markOrderDispatched']);
    Route::post('/mark_order_delivered',[\App\Http\Controllers\OrdersController::class,'markOrderDelivered']);
});

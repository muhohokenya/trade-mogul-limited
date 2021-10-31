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
    Route::post('/',[\App\Http\Controllers\VehiclesController::class,'store']);
    Route::put('/{id}',[\App\Http\Controllers\VehiclesController::class,'update']);
});

Route::group(['prefix'=>'orders'],function (){
    Route::get('/',[\App\Http\Controllers\OrdersController::class,'getAll']);
});

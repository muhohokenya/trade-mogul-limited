<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'depots'],function (){
    Route::get('/', [App\Http\Controllers\DepotController::class, 'index'])->name('depots.index');
});

Route::group(['prefix'=>'vehicles'],function (){
    Route::get('/', [App\Http\Controllers\VehiclesController::class, 'index'])->name('vehicles.index');
    Route::post('/store', [App\Http\Controllers\VehiclesController::class, 'store'])->name('vehicles.store');
});

Route::group(['prefix'=>'orders'],function (){
    Route::get('/', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders.index');
});

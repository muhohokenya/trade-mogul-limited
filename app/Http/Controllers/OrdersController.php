<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
   public function index(){
       return view('orders.index');
   }

   public function getAll(): JsonResponse
   {
       return response()->json(
           Order::all()
       );
   }
}

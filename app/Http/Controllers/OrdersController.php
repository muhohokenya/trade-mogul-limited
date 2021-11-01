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
           Order::query()->with(['vehicle'])->get()
       );
   }

   public function allocate(Request $request){
        $this->validate($request,[
            'vehicle'=>'required'
        ]);

        $order_id = $request->get('order_id');
        $vehicle_id = $request->get('vehicle');
        Order::query()->find($order_id)->update([
            'vehicle_id'=>$vehicle_id,
            'order_status'=>'loading'
        ]);
   }

   public function markOrderDispatched(Request $request){
       $order = $request->get('order');
       Order::markOrderComplete($order);
   }

   public function markOrderDelivered(Request $request){
       $order = $request->get('order');
       Order::markOrderDelivered($order);
   }

   public function getLoadingOrders(): JsonResponse
   {
        return response()->json(
            Order::getLoadingOrders()
        );
   }

   public function getDispatchedOrders(): JsonResponse
   {
        return response()->json(
            Order::getDispatchedOrders()
        );
   }

   public function getPendingOrders(): JsonResponse
   {
        return response()->json(
            Order::getPendingOrders()
        );
   }
}

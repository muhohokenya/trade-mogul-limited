<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id','order_status'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function depot(){
        return $this->belongsTo(Depot::class);
    }

    public static function markOrderComplete($order){
        self::query()->find($order)->update([
            'order_status'=>'dispatched'
        ]);
    }

    public static function markOrderDelivered($order){
        self::query()->find($order)->update([
            'order_status'=>'delivered'
        ]);
    }

    public static function getLoadingOrders(){
       return self::query()
            ->where('order_status','=','loading')
            ->get();
    }

    public static function getDispatchedOrders(){
       return self::query()
            ->where('order_status','=','dispatched')
            ->get();
    }

    public static function getPendingOrders(){
       return self::query()
            ->where('order_status','=','pending')
            ->get();
    }
}

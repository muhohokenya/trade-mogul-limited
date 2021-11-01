<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'reg_no','vehicle_status'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public static function getLastInserted(){
        return self::query()
            ->orderBy('created_at','desc')
            ->first();
    }

    public static function getLastUpdated(){
        return self::query()
            ->orderBy('updated_at','desc')
            ->first();
    }

    public static function getVehicleById($id){
        return self::query()
            ->find($id);
    }

    public static function markVehicleLoading($vehicle_id){
        self::query()->find($vehicle_id)->update([
            'vehicle_status'=>'loading'
        ]);
    }

    public static function markVehicleOnTransit($vehicle_id){
        self::query()->find($vehicle_id)->update([
            'vehicle_status'=>'on_transit'
        ]);
    }

    public static function markVehicleAvailable($vehicle_id){
        self::query()->find($vehicle_id)->update([
            'vehicle_status'=>'available'
        ]);
    }

    public function setRegNoAttribute($value)
    {
        $this->attributes['reg_no'] = strtoupper($value);
    }

    public function getVehicleStatusAttribute($key)
    {
        return ucwords($key);
    }
}

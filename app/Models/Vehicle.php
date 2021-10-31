<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'reg_no','vehicle_status'
    ];

    public static function getLastInserted(){
        return self::query()
            ->orderBy('created_at','desc')
            ->first();
    }

    public static function getVehicleById($id){
        return self::query()
            ->find($id);
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

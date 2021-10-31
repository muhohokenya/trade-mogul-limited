<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;


    protected $fillable = [
        'name'
    ];

    public static function getLastInserted(){
        return Depot::query()
            ->orderBy('created_at','desc')
            ->first();
    }

    public function getNameAttribute($key)
    {
        return ucwords($key);
    }


}

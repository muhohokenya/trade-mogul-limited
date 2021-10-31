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
        return self::query()
            ->orderBy('created_at','desc')
            ->first();
    }

    public function getNameAttribute($key): string
    {
        return ucwords($key);
    }


}

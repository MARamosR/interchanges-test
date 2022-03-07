<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Route;
use App\Models\LostEquipment;

class Operators extends Model
{
    use HasFactory;

    public function routes()
    {
        return $this->hasOne(Route::class);
    }

    public function getPreviousId () 
    {
        return DB::table('operators')->max('id');
    }

    public function lostEquipments() 
    {
        return $this->hasMany(LostEquipment::class);
    }
}

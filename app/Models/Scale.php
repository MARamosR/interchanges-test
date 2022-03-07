<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;
use App\Models\User;
use App\Models\LostEquipment;

class Scale extends Model
{
    use HasFactory;

    public function route()
    {
        return $this->belongsTo(Route::class, 'id_ruta');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'id_encargado');
    }

    public function lostEquipments() 
    {
        return $this->hasMany(LostEquipment::class);
    }
}

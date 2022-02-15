<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;

class LostEquipment extends Model
{
    use HasFactory;

    protected $fillable = ['id_route', 'id_equipment', 'ubicacion'];

    public function route()
    {
        return $this->belongsTo(Route::class, 'id_route');
    }
}

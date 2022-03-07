<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;
use App\Models\Operators;

class LostEquipment extends Model
{
    use HasFactory;

    protected $fillable = ['id_route', 'id_equipment', 'ubicacion', 'pagado', 'operators_id', 'nombre', 'folio'];

    public function route()
    {
        return $this->belongsTo(Route::class, 'id_route');
    }

    public function operator() 
    {
        return $this->belongsTo(Operators::class, 'operators_id');
    }
}

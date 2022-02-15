<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Container;
use App\Models\Unit;
use App\Models\Operators;
use App\Models\Scale;
use App\Models\Equipment;
use App\Models\User;
use App\Models\RouteInvoice;
use App\Models\RouteImage;
use App\Models\LostEquipment;
use Illuminate\Support\Facades\DB;

class Route extends Model
{
    use HasFactory;

    public function containers() 
    {
        return $this->belongsToMany(Container::class, 'route_containers', 'id_ruta', 'id_contenedor');
    }

    public function equipments() 
    {
        return $this->belongsToMany(Equipment::class, 'route_equipment', 'id_ruta', 'id_equipo');
    }

    public function scale()
    {
        return $this->hasMany(Scale::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unidad');
    }

    public function operator()
    {
        return $this->belongsTo(Operators::class, 'id_operador');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_encargado');
    }

    public function invoice() 
    {
        return $this->hasMany(RouteInvoice::class);
    }

    public function images()
    {
        return $this->hasMany(RouteImage::class);
    }

    public function lostEquipments()
    {
        return $this->hasMany(LostEquipment::class);
    }

    public function getPreviousId() 
    {
        return DB::table('routes')->max('id');
    }
}

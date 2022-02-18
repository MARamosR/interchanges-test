<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Provider;
use App\Models\Route;
use App\Models\EquipmentImage;


class Equipment extends Model
{
    use HasFactory;

    public function equipmentImage()
    {
        return $this->hasMany(EquipmentImage::class);
    }

    public function provider() 
    {
        return $this->belongsTo(Provider::class, 'id_proveedor');
    }

    public function routes()
    {
        return $this->belongsToMany(Route::class);
    }

    public function getPreviousId() 
    {
        return DB::table('equipment')->max('id');
    }

    public static function getPreviousIdFactory() 
    {
        return DB::table('equipment')->max('id');
    }
}

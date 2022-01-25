<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;
use App\Models\UnitImage;

class Unit extends Model
{
    use HasFactory;

    public function route()
    {
        $this->belongsTo(Route::class);
    }

    public function images() 
    {
        return $this->hasMany(UnitImage::class);
    }

    public function getPreviousId()
    {
        return DB::table('units')->max('id');
    }
}

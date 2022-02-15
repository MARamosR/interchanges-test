<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Route;
use App\Models\ContainerImage;


class Container extends Model
{
    use HasFactory;

    public function routes()
    {
        return $this->belongsToMany(Route::class);
    }

    public function containerImage()
    {
        return $this->hasMany(ContainerImage::class);
    }

    public function getPreviousId () 
    {
        return DB::table('containers')->max('id');
    }
}

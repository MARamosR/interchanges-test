<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;
use App\Models\Photo;

class Unit extends Model
{
    use HasFactory;

    public function route()
    {
        $this->belongsTo(Route::class);
    }

    public function photo() 
    {
        $this->hasMany(Photo::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;
use App\Models\Equipment;

class Container extends Model
{
    use HasFactory;

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }
}

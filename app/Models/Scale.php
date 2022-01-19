<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;

class Scale extends Model
{
    use HasFactory;

    public function route()
    {
        $this->belongsTo(Route::class);
    }
}

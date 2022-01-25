<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;
use App\Models\User;

class Scale extends Model
{
    use HasFactory;

    public function route()
    {
        $this->belongsTo(Route::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'id_encargado');
    }
}

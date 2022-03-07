<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Equipment;

class Provider extends Model
{
    use HasFactory;

    public function equipment() 
    {
        return $this->hasMany(Equipment::class);
    }
}

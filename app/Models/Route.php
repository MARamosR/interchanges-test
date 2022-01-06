<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Container;
use App\Models\Unit;
use App\Models\Operators;


class Route extends Model
{
    use HasFactory;

    public function container() 
    {
        $this->hasMany(Container::class);
    }

    public function unit()
    {
        $this->hasOne(Unit::class);
    }

    public function operator()
    {
        $this->hasOne(Operators::class);
    }
}

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
use Illuminate\Support\Facades\DB;

class Route extends Model
{
    use HasFactory;

    public function container() 
    {
        $this->hasMany(Container::class);
    }

    public function equipment() 
    {
        $this->hasMany(Equipment::class);
    }

    public function scale() 
    {
        $this->hasMany(Scale::class);
    }

    public function unit()
    {
        $this->hasOne(Unit::class);
    }

    public function operator()
    {
        $this->hasOne(Operators::class);
    }

    public function user()
    {
        $this->hasOne(User::class);
    }

    public function getPreviousId() 
    {
        return DB::table('routes')->max('id');
    }
}

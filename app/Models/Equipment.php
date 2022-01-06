<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Provider;
use App\Models\Container;


class Equipment extends Model
{
    use HasFactory;

    public function provider() 
    {
        $this->hasOne(Provider::class);
    }

    public function container()
    {
        $this->belongsTo(Container::class);
    }

    public function getPreviousId () 
    {
        return DB::table('equipment')->max('id');
    }
}

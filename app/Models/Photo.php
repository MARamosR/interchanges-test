<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Equipment;
use App\Models\Container;
use App\Models\Unit;

class Photo extends Model
{
    use HasFactory;

    public function equipment()
    {
        $this->belongsTo(Equipment::class);
    }

    public function container()
    {
        $this->belongsTo(Container::class);
    }

    public function unit()
    {
        $this->belongsTo(Unit::class);
    }
}

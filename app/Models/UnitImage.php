<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class UnitImage extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'unit_id'];

    public function units() 
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Route;

class RouteImage extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'route_id'];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}

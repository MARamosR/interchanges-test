<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Container;

class ContainerImage extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'container_id'];

    public function container()
    {
        return $this->belongsTo(Container::class, 'container_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Operators extends Model
{
    use HasFactory;

    public function getPreviousId () 
    {
        return DB::table('operators')->max('id');
    }
}

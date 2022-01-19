<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scale;
use App\Models\Route;
use App\Models\Equipment;
use App\Models\Container;
use App\Models\Operators;
use App\Models\Unit;

class ScaleController extends Controller
{
    public function create(Request $request, $id)
    {
        $route = Route::where('id', '=', $id)->first();
        
        return view('scale.create');
    }

    public function store() 
    {

    }
}

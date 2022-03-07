<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RouteInvoice;
use App\Models\Scale;
use App\Models\Route;
use PDF;

class ScaleController extends Controller
{
    public function create(Request $request, $id)
    {        
        $route      = Route::findOrFail($id);
        $containers = $route->containers;
        $equipment  = $route->equipments;
        $operator   = $route->operator;
        $unit       = $route->unit;
    
        return view('scales.create', compact(
            'route', 
            'containers', 
            'operator', 
            'unit', 
            'equipment'
        ));
    }

    public function store() 
    {
        
    }
}

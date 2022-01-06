<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Unit;
use App\Models\Operators;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::all();
        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Tenemos que llamar a otros modelos para rellenar selects en las vistas.
        $units = Unit::all();
        $operators = Operators::all();
        
        return view('routes.create', compact('units', 'operators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'salida'        => 'required|min:3',
            'fecha_salida'  => 'required',
            'destino'       => 'required|min:3',
            'fecha_destino' => 'nullable',
            'descripcion'   => 'nullable',
            'status'        => 'required',
            'unidad'        => 'required',
            'operador'      => 'required|min:3'
        ]);

        $route = new Route();
        $route->salida        = $validated['salida'];
        $route->fecha_salida  = $validated['fecha_salida'];
        $route->destino       = $validated['destino'];
        $route->fecha_destino = $validated['fecha_destino'];
        $route->descripcion   = $validated['descripcion'];
        $route->status        = $validated['status'];
        $route->unidad        = $validated['unidad'];
        $route->operador      = $validated['operador'];
        $route->save();
        
        return redirect()->route('routes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

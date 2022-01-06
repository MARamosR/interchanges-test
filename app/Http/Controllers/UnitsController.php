<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Provider;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();
        return view('unit.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validacion de los datos de entrada.
        $validated = $request->validate([
            'placa' => 'required|max:255',
            'marca' => 'required',
            'modelo' => 'required',
            'anio' => 'required'
        ]);

        $newUnit = new Unit();
        $newUnit->placa = $validated['placa'];
        $newUnit->marca = $validated['marca'];
        $newUnit->modelo = $validated['modelo'];
        $newUnit->anio = $validated['anio'];
        $newUnit->save();
        
        return redirect()->route('units.index');
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
        $unit = Unit::findOrFail($id);
        return view('unit.edit', ['unit' => $unit]);
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
        $validated = $request->validate([
            'placa' => 'required|max:255',
            'marca' => 'required',
            'modelo' => 'required',
            'anio' => 'required'
        ]);

        $unit = Unit::findOrFail($id);
        $unit->placa = $validated['placa'];
        $unit->marca = $validated['marca'];
        $unit->modelo = $validated['modelo'];
        $unit->anio = $validated['anio'];
        $unit->save();
    
        return redirect()->route('units.index');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('units.index');

    }
}

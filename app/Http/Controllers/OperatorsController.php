<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operators;

class OperatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operators = Operators::all();
        return view('operator.index', ['operators' => $operators]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('operator.create');
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
            'nombre'        => 'required',
            'apellidos'     => 'required',
            'telefono'      => 'required',
            'no_licencia'   => 'required',
            'tipo_licencia' => 'required',
            'fecha_exp'     => 'required|date',
            'fecha_venc'    => 'required|date|after:fecha_exp',
            'lugar_exp'     => 'required',
            'antiguedad'    => 'required',
            'iave'          => 'required',
            'ex_medico'     => 'required|date'
        ]);

        $operator = new Operators();
        $operator->nombre        = $validated['nombre'];
        $operator->apellidos     = $validated['apellidos'];
        $operator->telefono      = $validated['telefono'];
        $operator->no_licencia   = $validated['no_licencia'];
        $operator->tipo_licencia = $validated['tipo_licencia'];
        $operator->fecha_exp     = $validated['fecha_exp'];
        $operator->fecha_venc    = $validated['fecha_venc'];
        $operator->lugar_exp     = $validated['lugar_exp'];
        $operator->antiguedad    = $validated['antiguedad'];
        $operator->status = 0; // 1 = Activo (ocupado), 0 disponible para rutas.
        $operator->iave          = $validated['iave'];

        $previousId = $operator->getPreviousId();
        if ($previousId === null) {
            $previousId = 0;
        }
        $operator->folio         = 'OPR_' . $previousId + 1;
        $operator->ex_medico     = $validated['ex_medico'];
        $operator->save();

        return redirect()->route('operators.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $operator = Operators::findOrFail($id);
        return view('operator.edit', compact('operator'));
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
            'nombre'        => 'required',
            'apellidos'     => 'required',
            'telefono'      => 'required',
            'no_licencia'   => 'required',
            'tipo_licencia' => 'required',
            'fecha_exp'     => 'required',
            'fecha_venc'    => 'required',
            'lugar_exp'     => 'required',
            'antiguedad'    => 'required',
            'iave'          => 'required',
            'ex_medico'     => 'required'
        ]);

        $operator = Operators::findOrFail($id);
        $operator->nombre        = $validated['nombre'];
        $operator->apellidos     = $validated['apellidos'];
        $operator->telefono     = $validated['telefono'];
        $operator->no_licencia   = $validated['no_licencia'];
        $operator->tipo_licencia = $validated['tipo_licencia'];
        $operator->fecha_exp     = $validated['fecha_exp'];
        $operator->fecha_venc    = $validated['fecha_venc'];
        $operator->lugar_exp     = $validated['lugar_exp'];
        $operator->antiguedad    = $validated['antiguedad'];
        $operator->iave          = $validated['iave'];
        $operator->ex_medico     = $validated['ex_medico'];
        $operator->save();

        return redirect()->route('operators.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operator = Operators::findOrFail($id);        
        $operator->delete();

        return redirect()->route('operators.index');
    }
}

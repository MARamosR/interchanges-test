<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipment = Equipment::all();

        return view('equipment.index', compact('equipment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = DB::table('providers')->select('id', 'proveedor')->get();
        $provider = null;
        return view('equipment.create', compact('providers', 'provider'));
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
            'nombre'          => 'required',
            'descripcion'     => 'required',
            'precio_unitario' => 'required',
            'id_proveedor'    => 'required'
        ]);

        $equipment = new Equipment();
        $equipment->nombre          = $validated['nombre'];
        $equipment->descripcion     = $validated['descripcion'];
        $equipment->precio_unitario = $validated['precio_unitario'];
        $equipment->id_proveedor    = $validated['id_proveedor'];
        
        /*
            Por defecto esta disponible, este estado cambiara durante la asignación 
            de la ruta, si se crea una ruta que involucre a este equipo su estado
            cambiara a 1 => "En uso", cuando se termine la ruta su estado deberia de 
            cambiar a 2 => "Disponible" , en caso de que el operador no lo haya extraviado.
        */
        $equipment->activo = 2;

        // Obtenemos el id previo
        $previousId = $equipment->getPreviousId();
        if ($previousId === null) {
            $previousId = 0;
        }
        $folio = 'EQP_' . $previousId; 
        
        $equipment->folio = $folio;
        $equipment->save();

        return redirect()->route('equipment.index');
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
        $equipment = Equipment::findOrFail($id);
        $providers = DB::table('providers')->select('id', 'proveedor')->get();
        $provider = DB::table('providers')->select('id', 'proveedor')->where('id', $equipment->id_proveedor)->get();
        return view('equipment.edit', compact('equipment', 'providers', 'provider'));
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
            'nombre'          => 'required',
            'descripcion'     => 'required',
            'precio_unitario' => 'required',
            'id_proveedor'    => 'required'
        ]);

        //No vamos a permitir una actualización de folio.
        $equipment = Equipment::findOrFail($id);
        $equipment->nombre          = $validated['nombre'];
        $equipment->descripcion     = $validated['descripcion'];
        $equipment->precio_unitario = $validated['precio_unitario'];
        $equipment->id_proveedor    = $validated['id_proveedor'];
        $equipment->save();

        return redirect()->route('equipment.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipment.index');
    }
}

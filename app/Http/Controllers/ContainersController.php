<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Container;

class ContainersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $containers = Container::all();
        return view('containers.index', compact('containers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('containers.create');
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
            'serie'          => 'required',
            'marca'          => 'required',
            'modelo'         => 'required',
            'placa'          => 'required',
            'comentario'     => 'required',
            'placa_mx'       => 'required',
            'placa_ant'      => 'required',
            'estado'         => 'required',
            'riel_logistico' => 'required',
            'canastilla'     => 'required',
            'tipo_placa'     => 'required',
            'propietario'    => 'required',
            'ancho'          => 'required',
            'largo'          => 'required',
            'alto'           => 'required',
            'llanta'         => 'required',
            'llanta_status'  => 'required',
            'tipo_caja'      => 'required',
        ]);        

        $container =  new Container();
        $container->serie          = $validated['serie'];
        $container->marca          = $validated['marca'];
        $container->modelo         = $validated['modelo'];
        $container->placa          = $validated['placa'];
        $container->comentario     = $validated['comentario'];
        $container->placa_mx       = $validated['placa_mx'];        
        $container->placa_ant      = $validated['placa_ant'];
        $container->estado         = $validated['estado'];
        $container->riel_logistico = $validated['riel_logistico'];
        $container->canastilla     = $validated['canastilla'];
        $container->tipo_placa     = $validated['tipo_placa'];
        /*
            Cuando recien se crea por defecto sera 0, cuando se use en una ruta pasara a ser 1
            cuando la ruta sea eliminada o se termine volvera a ser 0 (otravez disponible).
        */
        $container->activo_status  = 0;
        $container->propietario    = $validated['propietario'];
        $container->ancho          = $validated['ancho'];
        $container->largo          = $validated['largo'];
        $container->alto          = $validated['alto'];
        $container->llanta         = $validated['llanta'];
        $container->llanta_status  = $validated['llanta_status'];
        $container->tipo_caja      = $validated['tipo_caja'];
        $container->save();

        // El id de la ruta se asignara cuando se cree una ruta

        return redirect()->route('containers.index');
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
        $contenedor = Container::findOrFail($id);
        return view('containers.edit', compact('contenedor'));
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
            'serie'          => 'required',
            'marca'          => 'required',
            'modelo'         => 'required',
            'placa'          => 'required',
            'comentario'     => 'required',
            'placa_mx'       => 'required',
            'placa_ant'      => 'required',
            'estado'         => 'required',
            'riel_logistico' => 'required',
            'canastilla'     => 'required',
            'tipo_placa'     => 'required',
            'propietario'    => 'required',
            'ancho'          => 'required',
            'largo'          => 'required',
            'alto'           => 'required',
            'llanta'         => 'required',
            'llanta_status'  => 'required',
            'tipo_caja'      => 'required',
        ]);        

        $container = Container::findOrFail($id);
        $container->serie          = $validated['serie'];
        $container->marca          = $validated['marca'];
        $container->modelo         = $validated['modelo'];
        $container->placa          = $validated['placa'];
        $container->comentario     = $validated['comentario'];
        $container->placa_mx       = $validated['placa_mx'];        
        $container->placa_ant      = $validated['placa_ant'];
        $container->estado         = $validated['estado'];
        $container->riel_logistico = $validated['riel_logistico'];
        $container->canastilla     = $validated['canastilla'];
        $container->tipo_placa     = $validated['tipo_placa'];
        $container->propietario    = $validated['propietario'];
        $container->ancho          = $validated['ancho'];
        $container->largo          = $validated['largo'];
        $container->alto          = $validated['alto'];
        $container->llanta         = $validated['llanta'];
        $container->llanta_status  = $validated['llanta_status'];
        $container->tipo_caja      = $validated['tipo_caja'];
        $container->save();

        return redirect()->route('containers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $container = Container::findOrFail($id);
        $container->delete();

        return redirect()->route('containers.index');
    }
}

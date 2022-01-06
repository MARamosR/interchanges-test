<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;

class ProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Provider::all();
        return view('provider.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('provider.create');
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
            'proveedor' => 'required|min:6',
            'direccion' => 'required|min:6',
            'ciudad'    => 'required|min:3',
            'telefono'  => 'required',
        ]);

        $newProvider = new Provider();
        $newProvider->proveedor = $validated['proveedor'];
        $newProvider->direccion = $validated['direccion'];
        $newProvider->ciudad    = $validated['ciudad'];
        $newProvider->telefono  = $validated['telefono'];
        $newProvider->save();

        return redirect()->route('providers.index');
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
        $proveedor = Provider::findOrFail($id);
        return view('provider.edit', compact('proveedor'));
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
            'proveedor' => 'required|min:6',
            'direccion' => 'required|min:6',
            'ciudad'    => 'required|min:3',
            'telefono'  => 'required',
        ]);

        $provider = Provider::findOrFail($id);
        $provider->proveedor = $validated['proveedor'];
        $provider->direccion = $validated['direccion'];
        $provider->ciudad    = $validated['ciudad'];
        $provider->telefono  = $validated['telefono'];
        $provider->save();

        return redirect()->route('providers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();

        return redirect()->route('providers.index');
    }
}

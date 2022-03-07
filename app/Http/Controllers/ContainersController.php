<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PostContainer;
use App\Models\Container;
use App\Models\ContainerImage;
use App\Models\SystemLog;

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
    public function store(PostContainer $request)
    {
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);
        
        SystemLog::create([
            'action' => 'Registro de contenedor',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        $container =  new Container();
        $container->serie          = $validated['serie'];
        $container->marca          = $validated['marca'];
        $container->modelo         = $validated['modelo'];
        $container->placa          = $validated['placa'];
        $container->comentario     = $validated['comentario'];
        $container->placa_mx       = $validated['placa_mx'];
        $container->placa_ant      = $validated['placa_ant'];
        $container->ubicacion         = $validated['ubicacion'];
        $container->riel_logistico = $validated['riel_logistico'];
        $container->canastilla     = $validated['canastilla'];
        $container->tipo_placa     = $validated['tipo_placa'];
        /*
            Cuando recien se crea por defecto sera 0, cuando se use en una ruta pasara a ser 1
            cuando la ruta sea eliminada o se termine volvera a ser 0 (otravez disponible).
        */
        $container->status  = 0;
        $container->propietario    = $validated['propietario'];
        $container->ancho          = $validated['ancho'];
        $container->largo          = $validated['largo'];
        $container->alto          = $validated['alto'];
        $container->llanta         = $validated['llanta'];
        $container->llanta_status  = $validated['llanta_status'];
        $container->tipo_caja      = $validated['tipo_caja'];

        $previousId = $container->getPreviousId();
        if ($previousId === null) {
            $previousId = 0;
        }
        $container->folio = 'CNTR_' . $previousId + 1;
        $container->save();

        if ($request->file('images') !== null) {
            DB::transaction(function () use ($container, $request) {

                foreach ($request->file('images') as $imageFile) {

                    $newImageName = floor((rand(1, 100) * time()) / rand(1, 10)) . '-' . $container->folio . '.' . $imageFile->extension();
                    $imagePath = public_path('/containerImages/');
                    $imageFile->move($imagePath, $newImageName);

                    ContainerImage::create([
                        'image_path' => '/containerImages/' . $newImageName,
                        'container_id' => $container->id
                    ]);
                }
            });
        }

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
        $container = Container::where('id', $id)->with(['containerImage'])->first();
        $containerImages = $container->containerImage;
        return view('containers.show', compact('container', 'containerImages'));
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
        $contanerImages = DB::table('container_images')->where('container_id', $id)->get();
        return view('containers.edit', compact('contenedor', 'contanerImages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostContainer $request, $id)
    {
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);
        
        SystemLog::create([
            'action' => 'Registro de contenedor',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        if ($request->input('deleteImageIds') !== null) {

            DB::transaction(function () use ($request) {
                foreach ($request->input('deleteImageIds') as $imageId) {

                    $image = ContainerImage::findOrFail($imageId);
                    File::delete(public_path($image->image_path));
                    $image->delete();
                }
            });
        }

        $container = Container::findOrFail($id);
        $container->serie          = $validated['serie'];
        $container->marca          = $validated['marca'];
        $container->modelo         = $validated['modelo'];
        $container->placa          = $validated['placa'];
        $container->comentario     = $validated['comentario'];
        $container->placa_mx       = $validated['placa_mx'];
        $container->placa_ant      = $validated['placa_ant'];
        $container->ubicacion         = $validated['ubicacion'];
        $container->riel_logistico = $validated['riel_logistico'];
        $container->canastilla     = $validated['canastilla'];
        $container->tipo_placa     = $validated['tipo_placa'];
        $container->propietario    = $validated['propietario'];
        $container->ancho          = $validated['ancho'];
        $container->largo          = $validated['largo'];
        $container->alto           = $validated['alto'];
        $container->llanta         = $validated['llanta'];
        $container->llanta_status  = $validated['llanta_status'];
        $container->tipo_caja      = $validated['tipo_caja'];

        if ($request->file('images') !== null) {
            DB::transaction(function () use ($container, $request) {

                foreach ($request->file('images') as $imageFile) {

                    $newImageName = floor((rand(1, 100) * time()) / rand(1, 10)) . '-' . $container->folio . '.' . $imageFile->extension();
                    $imagePath = public_path('/containerImages/');
                    $imageFile->move($imagePath, $newImageName);

                    ContainerImage::create([
                        'image_path' => '/containerImages/' . $newImageName,
                        'container_id' => $container->id
                    ]);
                }
            });
        }

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

        $log = collect($container);
        
        SystemLog::create([
            'action' => 'Registro de contenedor',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        DB::transaction(function () use ($id) {
            $containerImages = DB::table('container_images')->where('container_id', $id)->get();

            foreach ($containerImages as $image) {
                ContainerImage::destroy($image->id);
                File::delete(public_path($image->image_path));
            }
        });

        $container->delete();
        return redirect()->route('containers.index');
    }
}

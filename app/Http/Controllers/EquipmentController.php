<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Equipment;
use App\Models\EquipmentImage;
use App\Models\LostEquipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Models\SystemLog;
use Illuminate\Support\Facades\File;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipment = Equipment::with(['provider'])->get();
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
    public function store(StoreEquipmentRequest $request)
    {
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);
        
        SystemLog::create([
            'action' => 'Registro de equipo de sujeción',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        $equipment = new Equipment();
        $equipment->nombre          = $validated['nombre'];
        $equipment->descripcion     = $validated['descripcion'];
        $equipment->ubicacion     = $validated['ubicacion'];
        $equipment->precio_unitario = $validated['precio_unitario'];
        $equipment->id_proveedor    = $validated['id_proveedor'];

        /*
            cuando se crea es 0 (disponible), cuando se ocupa en una ruta pasa
            a ser 1 (activo o "en uso").
        */
        $equipment->activo = 0;

        // Obtenemos el id previo
        $previousId = $equipment->getPreviousId();
        if ($previousId === null) {
            $previousId = 0;
        }
        $folio = 'EQP_' . $previousId + 1;

        $equipment->folio = $folio;
        $equipment->save();

        if ($request->file('images') !== null) {
            DB::transaction(function () use ($request, $equipment) {

                foreach ($request->file('images') as $imageFile) {

                    $newImageName = floor((rand(1, 100) * time()) / rand(1, 10)) . '-' . $equipment->folio . '.' . $imageFile->extension();
                    $imagePath = public_path('/equipmentImages/');
                    $imageFile->move($imagePath, $newImageName);

                    EquipmentImage::create([
                        'image_path' => '/equipmentImages/' . $newImageName,
                        'equipment_id' => $equipment->id
                    ]);
                }
            });
        }



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
        /* Manejar caso donde el equipo de sujeción haya sido eliminado */
        $equipment = Equipment::where('id', $id)->with(['equipmentImage', 'provider'])->first();
        $paymentStatus = DB::table('lost_equipment')->where('id_equipment', '=', $id)->first();
            
        if (!$equipment) {
            return view('equipment.deleted');
        }
        
        return view('equipment.show', [
            'equipment'       => $equipment,
            'equipmentImages' => $equipment->equipmentImage,
            'provider'        => $equipment->provider,
            'paymentStatus'   => $paymentStatus !== null ? $paymentStatus->pagado : null  
        ]);
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
        $equipmentImages = DB::table('equipment_images')->where('equipment_id', $id)->get();

        return view('equipment.edit', compact(
            'equipment',
            'providers',
            'provider',
            'equipmentImages'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEquipmentRequest $request, $id)
    {
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);
        
        SystemLog::create([
            'action' => 'Actualizacion de equipo de sujeción',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        if ($request->input('deleteImageIds') !== null) {
            DB::transaction(function () use ($request) {

                foreach ($request->input('deleteImageIds') as $imageId) {

                    $image = EquipmentImage::findOrFail($imageId);
                    File::delete(public_path($image->image_path));
                    $image->delete();
                }
            });
        }


        $equipment = Equipment::findOrFail($id);
        $equipment->nombre          = $validated['nombre'];
        $equipment->descripcion     = $validated['descripcion'];
        $equipment->ubicacion       = $validated['ubicacion'];
        $equipment->precio_unitario = $validated['precio_unitario'];
        $equipment->id_proveedor    = $validated['id_proveedor'];

        if ($request->file('images') !== null) {
            DB::transaction(function () use ($request, $equipment) {

                foreach ($request->file('images') as $imageFile) {
                    $newImageName = floor((rand(1, 100) * time()) / rand(1, 10)) . '-' . $equipment->folio . '.' . $imageFile->extension();
                    $imagePath = public_path('/equipmentImages/');
                    // Almacenamos el archivo en la carpeta de nuestra elección y le asignamos al propio un nuevo nombre.
                    $imageFile->move($imagePath, $newImageName);

                    EquipmentImage::create([
                        'image_path' => '/equipmentImages/' . $newImageName,
                        'equipment_id' => $equipment->id
                    ]);
                }
            });
        }

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

        $log = collect($equipment);
        
        SystemLog::create([
            'action' => 'Eliminación de equipo de sujeción',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        DB::transaction(function () use ($id) {
            $equipmentImages = DB::table('equipment_images')->where(['equipment_id' => $id])->get();
            foreach ($equipmentImages as $image) {
                EquipmentImage::destroy($image->id);
                File::delete(public_path($image->image_path));
            }
        });

        $equipment->delete();

        return redirect()->route('equipment.index');
    }
}

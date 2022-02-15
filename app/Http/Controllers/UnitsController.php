<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Unit;
use App\Models\UnitImage;


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
        //Validación de los datos de entrada.
        $validated = $request->validate([
            'placa'  => 'required|max:255',
            'marca'  => 'required',
            'modelo' => 'required',
            'anio'   => 'required'
        ]);

        $newUnit = new Unit();
        $newUnit->placa  = $validated['placa'];
        $newUnit->marca  = $validated['marca'];
        $newUnit->modelo = $validated['modelo'];
        $newUnit->status = 0;

        $previousId = $newUnit->getPreviousId();
        if ($previousId === null) {
            $previousId = 0;
        }
        $newUnit->folio = 'UNIT_' . $previousId + 1;

        $newUnit->anio = $validated['anio'];
        $newUnit->save();

        if ($request->file('images') !== null) {

            DB::transaction(function () use ($newUnit, $request) {

                foreach ($request->file('images') as $imageFile) {
                    $newImageName = floor((rand(1, 100) * time()) / rand(1, 10)) . '-' . $newUnit->folio . '.' . $imageFile->extension();
                    $imagePath = public_path('/unitImages/');
                    $imageFile->move($imagePath, $newImageName);

                    UnitImage::create([
                        'image_path' => '/unitImages/' . $newImageName,
                        'unit_id' => $newUnit->id
                    ]);
                }
            });
        }

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
        $unit = Unit::where('id', $id)->with(['images'])->first();
        return view('unit.show', [
            'unit' => $unit, 
            'unitImages' => $unit->images
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
        $unit = Unit::findOrFail($id);
        $unitImages = DB::table('unit_images')->where('unit_id', $id)->get();
        return view('unit.edit', compact('unit', 'unitImages'));
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
            'placa'  => 'required|max:255',
            'marca'  => 'required',
            'modelo' => 'required',
            'anio'   => 'required'
        ]);

        // Borramos las imagenes seleccionadas
        if ($request->input('deleteImageIds') !== null) {
            DB::transaction(function () use ($request) {
                foreach ($request->input('deleteImageIds') as $imageId) {

                    $image = UnitImage::findOrFail($imageId);
                    File::delete(public_path($image->image_path));
                    $image->delete();
                }
            });
        }

        $unit = Unit::findOrFail($id);
        $unit->placa  = $validated['placa'];
        $unit->marca  = $validated['marca'];
        $unit->modelo = $validated['modelo'];
        $unit->anio   = $validated['anio'];
        $unit->save();

        // Agregamos las imagenes nuevas
        if ($request->file('images') !== null) {
            DB::transaction(function () use ($unit, $request) {

                foreach ($request->file('images') as $imageFile) {

                    $newImageName = floor((rand(1,100) * time()) / rand(1,10)) . '-' . $unit->folio . '.' . $imageFile->extension();
                    $imagePath = public_path('/unitImages/');
                    $imageFile->move($imagePath, $newImageName);

                    UnitImage::create([
                        'image_path' => '/unitImages/' . $newImageName,
                        'unit_id' => $unit->id
                    ]);
                }
            });
        }

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

        DB::transaction(function() use($id) {
            $unitImages = DB::table('unit_images')->where('unit_id', $id)->get();
            foreach ($unitImages as $image) {
                UnitImage::destroy($image->id);
                File::delete(public_path($image->image_path));
            }
        });

        $unit->delete();
        return redirect()->route('units.index');
    }
}

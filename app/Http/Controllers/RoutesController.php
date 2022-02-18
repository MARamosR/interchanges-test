<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\LostEquipment;
use App\Models\RouteInvoice;
use App\Models\RouteImage;
use App\Models\Operators;
use App\Models\Container;
use App\Models\Equipment;
use App\Models\Route;
use App\Models\Scale;
use App\Models\Unit;
use PDF;

use App\Rules\ArrayUnique;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eager loading para traer a las rutas junto con los encargados de las mismas 
        $routes = Route::with('user')->get();
        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*
            Tenemos que llamar a otros modelos para rellenar selects en las vistas, 
            solo los elementos disponibles (status 0).
        */
        $units = Unit::where('status', 0)->get();
        $operators = Operators::where('status', 0)->get();
        $containers = Container::where('status', 0)->get();
        $equipment = Equipment::where('activo', 0)->get();

        return view('routes.create', compact('units', 'operators', 'containers', 'equipment'));
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
            'fecha_salida'  => 'required|date',
            'destino'       => 'required|min:3',
            'fecha_destino' => 'required|date|after_or_equal:fecha_salida',
            'descripcion'   => 'required',
            'unidad'        => 'required',
            'operador'      => 'required',
            'contenedores'  => ['required', new ArrayUnique],
            'equipment'     => ['required', new ArrayUnique]
        ]);

        $route = new Route();
        $previousId = $route->getPreviousId();
        if ($previousId == null) {
            $previousId =  0;
        }
        $route->folio         = 'RT_' . $previousId + 1;
        $route->salida        = $validated['salida'];
        $route->fecha_salida  = $validated['fecha_salida'];
        $route->destino       = $validated['destino'];
        $route->fecha_destino = $validated['fecha_destino'];
        $route->descripcion   = $validated['descripcion'];
        $route->status        = 1;
        $route->id_encargado  = auth()->user()->id;
        $route->id_operador   = $validated['operador'];
        $route->id_unidad     = $validated['unidad'];
        $route->save();

        /*
            Actualizamos el status y el id de la ruta de
            los contenedores para indicar que estan en uso.
        */
        DB::transaction(function () use ($validated, $route) {
            
            foreach ($validated['contenedores'] as $key => $value) {
                $route->containers()->attach($value);
                
                $container = Container::where('id', $value)->first();
                $container->status = 1;
                $container->save();
            }
        });

        //Actualizamos el status y el id de la ruta de los equipo de sujeción para indicar que estan en uso.        
        DB::transaction(function () use ($validated, $route) {

            foreach ($validated['equipment'] as $key => $value) {
                $route->equipments()->attach($value);
                
                $equipment = Equipment::where('id', $value)->first();
                $equipment->activo = 1;
                $equipment->save();
            }
        });

        if ($request->file('images') !== null) {
            DB::transaction(function () use ($request, $route) {
                
                foreach ($request->file('images') as $imageFile) {
                    $newImageName = floor((rand(1, 100) * time()) / rand(1, 10)) . '-' . $route->folio . '.' . $imageFile->extension();
                    $imagePath = public_path('/routeImages/');
                    $imageFile->move($imagePath, $newImageName);
                    
                    RouteImage::create([
                        'route_id' => $route->id,
                        'path'    => '/routeImages/' . $newImageName
                    ]);
                }
            });
        }

        DB::table('operators')->where('id', $validated['operador'])->update(['status' => 1]);
        DB::table('units')->where('id', $validated['unidad'])->update(['status' => 1]);

        self::storeRouteStartInvoice($route->id);
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
        $route = Route::where('id', $id)->with(['invoice', 'images', 'equipments' , 'containers', 'operator', 'unit'])->first();

        return view('routes.show', [
            'route'      => $route,
            'containers' => $route->containers,
            'equipment'  => $route->equipments,
            'operator'   => $route->operator,
            'unit'       => $route->unit,
            'invoices'   => $route->invoice,
            'images'     => $route->images
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
        //Eliminamos todo lo relacionado con la ruta.
        $route = Route::findOrFail($id);
        
        DB::transaction(function() use($id) {
            $routeImages = DB::table('route_images')->where('route_id', $id)->get();

            foreach ($routeImages as $image) {
                RouteImage::destroy($image->id);
                File::delete(public_path($image->path));
            }
        });

        DB::transaction(function () use($id) {
            $routeInvoices = DB::table('route_invoices')->where('route_id', $id)->get();

            foreach ($routeInvoices as $invoice) {
                RouteInvoice::destroy($invoice->id);
                File::delete(public_path($invoice->doc_path));
            }
        });
        
        $route->delete();

        //Eliminamos todo lo relacionado con las escalas de la ruta.
        $scales = Scale::where('id_ruta', $id)->get();
        
        
        return redirect()->route('routes.index');

    }

    public static function storeRouteStartInvoice($id)
    {

        $route      = Route::findOrFail($id);
        $containers = $route->containers;
        $equipment  = $route->equipments;
        $operator   = $route->operator;
        $unit       = $route->unit;

        $containersQty = count($containers);
        $equipmentQty  = count($equipment);

        $equipmentTotal = 0;
        foreach ($equipment as $value) {
            $equipmentTotal += $value->precio_unitario;
        }

        $pdf = PDF::loadView('pdf.routeStart', compact(
            'route',
            'containers',
            'equipment',
            'operator',
            'unit',
            'containersQty',
            'equipmentQty',
            'equipmentTotal'
        ));

        $fileName = uniqid() . '_' . $route->folio . '_' . '.pdf'; // Creamos el nombre del archivo
        $path = public_path('/routeInvoices/') . $fileName; // Creamos el path del archivo 
        File::append($path, $pdf->output());

        $invoice = new RouteInvoice();
        $invoice->descripcion = 'Inicio de la ruta';
        $invoice->doc_path = '/routeInvoices/' . $fileName;
        $invoice->route_id = $id;
        $invoice->save();
    }

    public function showInvoice($id)
    {
        $invoice = RouteInvoice::findOrFail($id);
        $path = public_path($invoice->doc_path);

        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $invoice->doc_path . '"'
        ];

        return response()->file($path, $header);
    }


    /**
     * Call the view to store a new scale
     */
    public function createScale($id)
    {
        //FIXME: Se estan borrando los equipos de sujeción sin razón.
        $route = Route::where('id', $id)->with(['images', 'equipments' , 'containers', 'operator', 'unit'])->first();
        $availableEquipment = DB::table('route_equipment')
                                ->where('id_ruta', $id)
                                ->join('equipment', 'route_equipment.id_equipo', '=', 'equipment.id')
                                ->where('equipment.activo', '<>', 0)
                                ->where('equipment.activo', '<>', 2)
                                ->select('equipment.nombre', 'equipment.id')
                                ->get();

        return view('routes.createScale', [
            'route'      => $route,
            'containers' => $route->containers,
            'equipment'  => $availableEquipment,
            'operator'   => $route->operator,
            'unit'       => $route->unit,
            'images'     => $route->images
        ]);
    }


    /**
     * store a new scale into the database
     */
    public function storeScale(Request $request, $id)
    {   //FIXME: NO FUNCIONA CUANDO SOLO SE PIERDE UN EQUIPO, AUNQUE SE MARQUE SOLO UNO COMO EXTRAVIADO SE MARCAN LOS DOS
        
        $validated = $request->validate([
            'fecha'       => 'required|date',
            'ubicacion'   => 'required',
            'descripcion' => 'required',
        ]);

        $scale              = new Scale();
        $scale->fecha       = $validated['fecha'];
        $scale->ubicacion   = $validated['ubicacion'];
        $scale->descripcion = $validated['descripcion'];
        $scale->id_ruta     = $id;
        $scale->id_encargado   = auth()->user()->id;
        $scale->save();

        $lostEquipmentArray = []; 
        if ($request->input('lostEquipment') !== null) {
            $lostEquipmentArray = $request->input('lostEquipment');
        }
        
        if (count($lostEquipmentArray) > 0) {
            DB::transaction(function () use ($lostEquipmentArray, $id) {
                foreach ($lostEquipmentArray as $equipmentId) {
                    
                    $lostEquipmentItem = Equipment::findOrFail($equipmentId);
                    $lostEquipmentItem->activo = 2;
                    $lostEquipmentItem->save();
    
                    LostEquipment::create([
                        'id_route'     => $id,
                        'id_equipment' => $lostEquipmentItem->id
                    ]);
                }
            });
        }
        

        $scaleEquipmentArray = []; 
        if ($request->input('scaleEquipment') !== null) {
            $scaleEquipmentArray = $request->input('scaleEquipment');
        }

        if (count($scaleEquipmentArray) > 0) {
            DB::transaction(function () use ($scaleEquipmentArray, $validated) {
                foreach ($scaleEquipmentArray as $equipmentId) { 
                    
                    $scaleEquipmentItem = Equipment::findOrFail($equipmentId);
                    $scaleEquipmentItem->activo = 0;
                    $scaleEquipmentItem->ubicacion = $validated['ubicacion'];
                    $scaleEquipmentItem->save();
                }
            });
        }

        self::storeScaleInvoice($id, $lostEquipmentArray, $scaleEquipmentArray, $scale);
        return redirect()->route('routes.index');
    }

    public static function storeScaleInvoice($id, $lostEquipment, $scaleEquipment, $scale) 
    {
        $route = Route::where('id', $id)->with(['equipments' , 'containers', 'operator', 'unit'])->first();

        $containers = $route->containers;
        $equipment = $route->equipments;
        $operator = $route->operator;
        $unit = $route->unit;

        $containersQty = count($containers);
        $equipmentQty = count($equipment);
        $lostEquipmentQty = 0;
        if ($lostEquipment !== null) {
            $lostEquipmentQty = count($lostEquipment);
        }

        $scaleEquipmentQty = 0;
        if ($scaleEquipment !== null) {
            $scaleEquipmentQty = count($scaleEquipment);
        }
        
        $scaleEquipmentArray = [];
        if ($scaleEquipment !== null) {
            foreach ($scaleEquipment as $equipmentId) {
                $equipmentItem = Equipment::findOrFail($equipmentId);
                array_push($scaleEquipmentArray, $equipmentItem);
            }
        }

        
        //FIXME: No se registran correctamente los arreglos equipment
        $equipmentTotal = 0;
        foreach ($equipment as $value) {
            $equipmentTotal += $value->precio_unitario;
        }

        $lostEquipmentArray = [];
        $lostEquipmentTotal = 0;
        if ($lostEquipment !== null) {
            foreach ($lostEquipment as $equipmentId) {
                $equipmentItem = Equipment::findOrFail($equipmentId); //CREO QUE CAMBIANDO EL $id por $equipmentId se arregla el rejodido problema...
                $lostEquipmentTotal += $equipmentItem->precio_unitario;
                array_push($lostEquipmentArray, $equipmentItem);
            }
        }

        $pdf = PDF::loadView('pdf.scale', compact(
            'route',
            'containers',
            'equipment',
            'operator',
            'unit',
            'containersQty',
            'equipmentQty',
            'equipmentTotal',
            'lostEquipmentArray',
            'lostEquipmentQty',
            'lostEquipmentTotal',
            'scale',
            'scaleEquipmentArray',
            'scaleEquipmentQty'
        ));

        $fileName = uniqid() . '_' . $route->folio . '_' . '.pdf'; // Creamos el nombre del archivo
        $path = public_path('/routeInvoices/') . $fileName; // Creamos el path del archivo 
        File::append($path, $pdf->output());

        $invoice = new RouteInvoice();
        $invoice->descripcion = 'Escala en ' . $scale->ubicacion;
        $invoice->doc_path = '/routeInvoices/' . $fileName;
        $invoice->route_id = $id;
        $invoice->save();
    }
}

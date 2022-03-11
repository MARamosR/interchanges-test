<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\StoreScaleRequest;
use App\Models\LostEquipment;
use App\Models\RouteInvoice;
use App\Models\RouteImage;
use App\Models\SystemLog;
use App\Models\Operators;
use App\Models\Container;
use App\Models\Equipment;
use App\Models\Route;
use App\Models\Scale;
use App\Models\Unit;
use PDF;

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

        return view('routes.create', compact(
            'units', 
            'operators', 
            'containers', 
            'equipment'
        ));
    }

    /** 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRouteRequest $request)
    {
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);

        SystemLog::create([
            'action' => 'Registro de ruta',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
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
        return redirect()->route('routes.show', ['route' => $route->id]);
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

        $availableEquipment = DB::table('route_equipment')
                                ->where('id_ruta', $id)
                                ->join('equipment', 'route_equipment.id_equipo', '=', 'equipment.id')
                                ->where('equipment.activo', '<>', 0)
                                ->where('equipment.activo', '<>', 2)
                                ->select('equipment.nombre', 'equipment.id')
                                ->get();

        if (count($availableEquipment) > 0) {
            DB::transaction(function() use($availableEquipment) {
                
                foreach ($availableEquipment as $availableEquipmentItem) {
                    DB::table('equipment')->where('id', $availableEquipmentItem->id)->update(['activo' => 0]);
                }
            });
        }

        $route = Route::findOrFail($id);
        
        $log = collect($route);

        SystemLog::create([
            'action' => 'Eliminación de ruta',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

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
        $scales = Scale::where('id_ruta', $id)->delete();
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
    public function createScale($id, $endRoute = null)
    {
        $route = Route::where('id', $id)->with(['images', 'equipments' , 'containers', 'operator', 'unit'])->first();
        $availableEquipment = DB::table('route_equipment')
                                ->where('id_ruta', $id)
                                ->join('equipment', 'route_equipment.id_equipo', '=', 'equipment.id')
                                ->where('equipment.activo', '<>', 0)
                                ->where('equipment.activo', '<>', 2)
                                ->select('equipment.nombre', 'equipment.id')
                                ->get();

        if ($endRoute) { // Vista para cuando terminamos una ruta...
            return view('routes.endRoute', [
                'route'      => $route,
                'containers' => $route->containers,
                'equipment'  => $availableEquipment,
                'operator'   => $route->operator,
                'unit'       => $route->unit,
                'images'     => $route->images
            ]);
        }

        return view('routes.createScale', [
            'route'      => $route,
            'containers' => $route->containers,
            'equipment'  => $availableEquipment,
            'operator'   => $route->operator,
            'unit'       => $route->unit,
            'images'     => $route->images
        ]);
    }

    public function endRoute(StoreScaleRequest $request, $id)
    {
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);

        SystemLog::create([
            'action' => 'Registro de finalización de ruta',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        $route = Route::where('id', $id)->with(['operator', 'containers', 'unit'])->first();

        $route->status = 0; // 0 = Ruta finalizada
        $route->fecha_termino = $validated['fecha']; 
        $route->save();

        
        foreach ($route->containers as $container) {
            DB::table('containers')
                    ->where('id', $container->id)
                    ->update(['status' => 0]);    
        } 
        
        DB::table('operators')->where('id', $route->operator->id)->update(['status' => 0]);
        DB::table('units')->where('id', $route->unit->id)->update(['status' => 0]);

        $endEquipmentArr = $request->input('endEquipment');

        if ($endEquipmentArr !== null) {
            foreach ($endEquipmentArr as $equipmentId) {
                $equipment = Equipment::findOrFail($equipmentId);
                $equipment->activo = 0;
                $equipment->ubicacion = $validated['ubicacion'];
                $equipment->save();
            }
        }

        self::storeEndRouteInvoice($id, $endEquipmentArr, $validated['fecha'], $validated['ubicacion'], $validated['descripcion']);    
        return redirect()->route('routes.index');

    }

    /**
     * store a new scale into the database
     */
    public function storeScale(StoreScaleRequest $request, $id) //TODO: VER SI  FUNCIONA
    {   
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);

        SystemLog::create([
            'action' => 'Registro de escala',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        $route = Route::where('id', $id)->with(['operator'])->first();

        $scale              = new Scale();
        $scale->fecha       = $validated['fecha'];
        $scale->ubicacion   = $validated['ubicacion'];
        $scale->descripcion = $validated['descripcion'];
        $scale->id_ruta     = $route->id;
        $scale->id_encargado   = auth()->user()->id;
        $scale->save();

        // Validar que no se marque como perdido y en escala al mismo equipo de sujecion
        if ($request->input('lostEquipment') !== null && $request->input('scaleEquipment') !== null) {
            foreach ($request->input('lostEquipment') as $lostEquipmentItem) {
                if (in_array($lostEquipmentItem, $request->input('scaleEquipment'))) {
                    return redirect()->back()->withInput()->with('EquipmentError', 'El mismo equipo de sujeción no puede quedarse en la escala y estar extraviado al mismo tiempo.');
                }
            }
        }


        $lostEquipmentArray = []; 
        if ($request->input('lostEquipment') !== null) {
            $lostEquipmentArray = $request->input('lostEquipment');
        }

        if (count($lostEquipmentArray) > 0) {
            DB::transaction(function () use ($lostEquipmentArray, $route, $validated) {
                foreach ($lostEquipmentArray as $equipmentId) {
                    
                    $lostEquipmentItem = Equipment::findOrFail($equipmentId);
                    $lostEquipmentItem->activo = 2;
                    $lostEquipmentItem->save();
    
                    LostEquipment::create([
                        'id_route'     => $route->id,
                        'id_equipment' => $lostEquipmentItem->id,
                        'nombre'       => $lostEquipmentItem->nombre,
                        'folio'        => $lostEquipmentItem->folio,
                        'pagado'       => false,
                        'ubicacion'    => $validated['ubicacion'],
                        'operators_id' => $route->operator->id
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

        $equipmentTotal = 0;
        foreach ($equipment as $value) {
            $equipmentTotal += $value->precio_unitario;
        }

        $lostEquipmentArray = [];
        $lostEquipmentTotal = 0;
        if ($lostEquipment !== null) {
            foreach ($lostEquipment as $equipmentId) {
                $equipmentItem = Equipment::findOrFail($equipmentId);
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

    public static function storeEndRouteInvoice($id, $equipment, $fechaTermino, $ubication, $description) 
    {
        $route = Route::where('id', $id)->with(['equipments' , 'containers', 'operator', 'unit'])->first();
        

        $equipmentQty = count($route->equipments);
        $equipmentTotal = 0;
        if ($equipmentQty > 0) {
            foreach ($route->equipments as $route_eq) {
                $equipmentTotal += $route_eq->precio_unitario;
            }
        }

        $lostEquipmentQty = 0;
        $lostEquipmentArr = $route->equipments->filter(function($equipment) {
            if ($equipment->activo === 2) {
                return $equipment;
            }
        });

        $lostEquipmentQty = count($lostEquipmentArr);

        $lostEquipmentTotal = 0;
        if ($lostEquipmentQty > 0) {
            foreach ($lostEquipmentArr as $lostEquipmentItem) {
                $lostEquipmentTotal += $lostEquipmentItem->precio_unitario;
            }
        }

        $containersQty = 0;
        if ($route->containers !== null) {
            $containersQty = count($route->containers);
        }

        // Route "Summary" pdf.
        $pdf = PDF::loadView('pdf.endRoute', [ 
            'route'              => $route,
            'operator'           => $route->operator,
            'unit'               => $route->unit,
            'containers'         => $route->containers,
            'containersQty'      => $containersQty,
            'endEquipment'       => $equipment,
            'equipment'          => $route->equipments,
            'equipmentTotal'     => $equipmentTotal,
            'fechaTermino'       => $fechaTermino,
            'ubicacion'          => $ubication,
            'descripcion'        => $description,
            'lostEquipmentArr'   => $lostEquipmentArr,
            'lostEquipmentQty'   => $lostEquipmentQty,
            'lostEquipmentTotal' => $lostEquipmentTotal,
            'equipmentQty'       => $equipmentQty
        ]);

        $fileName = uniqid() . '_' . $route->folio . '_' . '.pdf'; // Creamos el nombre del archivo
        $path = public_path('/routeInvoices/') . $fileName; // Creamos el path del archivo 
        File::append($path, $pdf->output());

        $invoice = new RouteInvoice();
        $invoice->descripcion = 'Ruta finalizada ' . $ubication;
        $invoice->doc_path = '/routeInvoices/' . $fileName;
        $invoice->route_id = $id;
        $invoice->save();
    
    }
}

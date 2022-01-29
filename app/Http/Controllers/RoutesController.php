<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Operators;
use App\Models\Container;
use App\Models\Equipment;
use App\Models\Route;
use App\Models\Unit;
use App\Models\RouteInvoice;
use Barryvdh\DomPDF\PDF as DomPDF;
use Illuminate\Support\Facades\File;

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
            'fecha_salida'  => 'required',
            'destino'       => 'required|min:3',
            'fecha_destino' => 'nullable',
            'descripcion'   => 'nullable',
            'unidad'        => 'required',
            'operador'      => 'required',
            'contenedores'  => 'required',
            'equipment'     => 'required'
        ]);

        //Cambiamos el estado del operador
        DB::table('operators')
            ->where('id', $validated['operador'])
            ->update(['status' => 1]);

        //Cambiamos el estado de la unidad
        DB::table('units')
            ->where('id', $validated['unidad'])
            ->update(['status' => 1]);

        // Rellenamos un hashmap para hallar valores duplicados.
        $containerIds = [];
        foreach ($request->input('contenedores') as $key => $value) {
            if (isset($containerIds[$value])) {
                $containerIds[$value] += 1;
            } else {
                $containerIds[$value] = 1;
            }
        }

        // Recorremos el hashmap para encontrar valores duplicados.
        foreach ($containerIds as $key => $value) {
            if ($value > 1) {

                //Si hay un duplicado, volvemos a la url anterior con un mensaje de sesión que nos indique el error.
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('message', 'No puedes agregar el mismo contenedor dos veces en una misma ruta...');
            }
        }

        $equipmentIds = [];
        foreach ($request->input('equipment') as $key => $value) {
            if (isset($equipmentIds[$value])) {
                $equipmentIds[$value] += 1;
            } else {
                $equipmentIds[$value] = 1;
            }
        }

        foreach ($equipmentIds as $key => $value) {
            if ($value > 1) {
                //Si hay un duplicado, volvemos a la url anterior con un mensaje de sesión que nos indique el error.
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('message', 'No puedes agregar el mismo equipo de sujeción dos veces en una misma ruta...');
            }
        }

        $route = new Route();
        $previousId = $route->getPreviousId();
        if ($previousId == null) {
            $previousId =  0;
        }
        $route->folio = 'RT_' . $previousId;
        $route->salida        = $validated['salida'];
        $route->fecha_salida  = $validated['fecha_salida'];
        $route->destino       = $validated['destino'];
        $route->fecha_destino = $validated['fecha_destino'];
        $route->descripcion   = $validated['descripcion'];
        $route->status        = 1;
        $route->id_unidad     = $validated['unidad'];
        $route->id_operador   = $validated['operador'];
        $route->id_encargado  = auth()->user()->id; //El encargado es la persona logeada.
        $route->save();

        /*
            Actualizamos el status y el id de la ruta de
            los contenedores para indicar que estan en uso.
        */
        foreach ($request->input('contenedores') as $key => $value) {
            DB::table('containers')
                ->where('id', $value)
                ->update(['status' => 1, 'id_ruta' => $route->id]);
        }

        //Actualizamos el status y el id de la ruta de los equipo de sujeción para indicar que estan en uso.        
        foreach ($request->input('equipment') as $key => $value) {
            DB::table('equipment')
                ->where('id', $value)
                ->update(['activo' => 1, 'id_ruta' => $route->id]);
        }

        $pdf = self::storeRouteStartInvoice($route->id);
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
        $route = Route::where('id', $id)->with(['invoice'])->first();
        $containers    = Container::where('id_ruta', $id)->with('containerImage')->get();
        $equipment     = Equipment::where('id_ruta', $id)->with('equipmentImage')->get();
        $operator      = Operators::findOrFail($route->id_operador);
        $unit          = Unit::findOrFail($route->id_unidad)->with('images')->get();

        return view('routes.show', compact(
            'route',
            'containers',
            'equipment',
            'operator',
            'unit'
        ));
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
        //
    }

    public static function storeRouteStartInvoice($id)
    {

        $route         = Route::findOrFail($id);
        $containers    = Container::where('id_ruta', $id)->get();
        $equipment     = Equipment::where('id_ruta', $id)->get();
        $operator      = Operators::findOrFail($route->id_operador);
        $unit          = Unit::findOrFail($route->id_unidad);

        //TODO: Probar que la forma de obtener la cantidad funcione de forma correcta.
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
        $invoice->doc_path = '/routeInvoices/' . $fileName;
        $invoice->route_id = $id;
        $invoice->save();
    }

    public function showRouteInvoice(Request $request, $fileName)
    {
        dd($fileName);
        $path = public_path('routeInvoices/' . $file);

        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $file . '"'
        ];

        return response()->file($path, $header);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Unit;
use App\Models\Operators;
use App\Models\Container;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::all();
        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Tenemos que llamar a otros modelos para rellenar selects en las vistas.
        $units = Unit::all();
        $operators = Operators::all();
        $containers = Container::where('activo_status', 0)->get();
        $equipment = Equipment::all();
        
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
        //TODO: Validar los arreglos dinamicos que vienen del request
        $validated = $request->validate([
            'salida'        => 'required|min:3',
            'fecha_salida'  => 'required',
            'destino'       => 'required|min:3',
            'fecha_destino' => 'nullable',
            'descripcion'   => 'nullable', 
            'unidad'        => 'required',
            'operador'      => 'required'
        ]);

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
                    ->with('containersMessage', 'No puedes agregar el mismo contenedor dos veces en una misma ruta...');
            }
        }

        // Actualizamos el status_activo de los contenedores.
        foreach ($request->input('contenedores') as $key => $value) {
            DB::table('containers')
                ->where('id', $value)
                ->update(['activo_status' => 1]);
        }

        //TODO: Actualizar el status de los equipos de sujeción para ver si estan ocupadas (en ruta) o disponibles.
        //TODO: Actualizar el status de los operadores para ver si este esta ocupado (en ruta) o disponible.
        // TODO: Actualizar el status de las unidades para ver si estan ocupadas (en ruta) o disponibles.

        $route = new Route();
        $route->salida        = $validated['salida'];
        $route->fecha_salida  = $validated['fecha_salida'];
        $route->destino       = $validated['destino'];
        $route->fecha_destino = $validated['fecha_destino'];
        $route->descripcion   = $validated['descripcion'];

        //TODO: CAMBIAR, CUANDO SE CREAR UNA RUTA POR DEFECTO SERA ACTIVO, CUANDO SE TERMINE LA RUTA PASARA A SER INACTIVA
        $route->status        = 2;
        $route->id_unidad     = $validated['unidad'];
        $route->id_operador   = $validated['operador'];
        $route->save();
        
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
}

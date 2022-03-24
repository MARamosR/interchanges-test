<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\LostEquipment;
use Illuminate\Http\Request;
use App\Models\Operators;
use App\Models\SystemLog;
use App\Http\Requests\StoreOperatorRequest;

class OperatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operators = Operators::all();
        return view('operator.index', ['operators' => $operators]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('operator.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOperatorRequest $request)
    {
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);
        
        SystemLog::create([
            'action' => 'Registro de operador',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        $operator = new Operators();
        $operator->nombre        = $validated['nombre'];
        $operator->apellidos     = $validated['apellidos'];
        $operator->telefono      = $validated['telefono'];
        $operator->no_licencia   = $validated['no_licencia'];
        $operator->tipo_licencia = $validated['tipo_licencia'];
        $operator->fecha_exp     = $validated['fecha_exp'];
        $operator->fecha_venc    = $validated['fecha_venc'];
        $operator->lugar_exp     = $validated['lugar_exp'];
        $operator->antiguedad    = $validated['antiguedad'];
        $operator->status = 0; // 1 = Activo (ocupado), 0 disponible para rutas.
        $operator->iave          = $validated['iave'];

        $previousId = $operator->getPreviousId();
        if ($previousId === null) {
            $previousId = 0;
        }
        $operator->folio         = 'OPR_' . $previousId + 1;
        $operator->ex_medico     = $validated['ex_medico'];
        $operator->save();

        return redirect()->route('operators.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operator = Operators::where('id', $id)->with(['lostEquipments'])->first();

        return view('operator.show', [
            'operator' => $operator,
            'lostEquipments' => $operator->lostEquipments
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
        $operator = Operators::findOrFail($id);
        return view('operator.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOperatorRequest $request, $id)
    {
        $validated = $request->validated();

        $log = collect($request->all())->except(['_token']);
        
        SystemLog::create([
            'action' => 'Actualización de operador',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);

        $operator = Operators::findOrFail($id);
        $operator->nombre        = $validated['nombre'];
        $operator->apellidos     = $validated['apellidos'];
        $operator->telefono     = $validated['telefono'];
        $operator->no_licencia   = $validated['no_licencia'];
        $operator->tipo_licencia = $validated['tipo_licencia'];
        $operator->fecha_exp     = $validated['fecha_exp'];
        $operator->fecha_venc    = $validated['fecha_venc'];
        $operator->lugar_exp     = $validated['lugar_exp'];
        $operator->antiguedad    = $validated['antiguedad'];
        $operator->iave          = $validated['iave'];
        $operator->ex_medico     = $validated['ex_medico'];
        $operator->save();

        return redirect()->route('operators.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operator = Operators::findOrFail($id);
        
        $log = collect($operator);
        
        SystemLog::create([
            'action' => 'Eliminación de operador',
            'data'   => json_encode($log),
            'user'   => auth()->user()->name
        ]);
        
        $operator->delete();

        return redirect()->route('operators.index');
    }

    public function equipmentPay($operatorId, $equipmentId)
    {
        $lostEquipment = LostEquipment::findOrFail($equipmentId);
        $lostEquipment->pagado = true;

        $equipment = Equipment::where('id', $lostEquipment->id_equipment)->first();

        SystemLog::create([
            'action' => 'Pago de equipo',
            'data'   => json_encode($equipment),
            'user'   => auth()->user()->name
        ]);

        $lostEquipment->save();

        return redirect()->route('operators.show', ['operator' => $operatorId]);
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $routesQty     = DB::table('routes')->count();
        $unitsQty      = DB::table('units')->count();
        $equipmentQty  = DB::table('equipment')->count();
        $containersQty = DB::table('containers')->count();
        $operatorsQty  = DB::table('operators')->count();
        $providersQty  = DB::table('providers')->count();

        $lostEquipment = DB::table('equipment')->where('activo', '=', 2)->get();
        $lostEquipmentQty = $lostEquipment->count();
        $lostEquipmentTotal = $lostEquipment->sum('precio_unitario');

        return view('dashboard', compact(
            'routesQty',
            'unitsQty',
            'equipmentQty',
            'containersQty',
            'operatorsQty',
            'providersQty',
            'lostEquipmentTotal',
            'lostEquipmentQty'
        ));
    }
}

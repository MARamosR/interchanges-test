<?php

namespace App\Http\Controllers;

use App\Models\LostEquipment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // $request->path() = 'index'
        if (view()->exists($request->path())) {

            return view($request->path());
        }
        return abort(404);
    }

    public function root()
    {   

        $routesQty     = DB::table('routes')->count();
        $unitsQty      = DB::table('units')->count();
        $equipmentQty  = DB::table('equipment')->count();
        $containersQty = DB::table('containers')->count();
        $operatorsQty  = DB::table('operators')->count();
        $providersQty  = DB::table('providers')->count();
        
        // Esto es para que conforme se van pagando equipos, se vaya descontando
        // $lostEquipment = DB::table('lost_equipment')
        //     ->where('pagado', false)
        //     ->join('equipment', 'lost_equipment.id_equipment', 'equipment.id')
        //     ->select('equipment.precio_unitario')
        //     ->get();       
        
        // $lostEquipmentQty = count($lostEquipment);
        // $lostEquipmentTotal = 0;
        // foreach ($lostEquipment as $equipment) {
        //     $lostEquipmentTotal += $equipment->precio_unitario;
        // }

        
        $lostEquipment = DB::table('equipment')->where('activo', '=', 2)->get();
        $lostEquipmentQty = $lostEquipment->count();
        $lostEquipmentTotal = $lostEquipment->sum('precio_unitario');
        

        // foreach ($lostEquipment as $lostEquipmentItem) {
        //     $lostEquipmentTotal += $lostEquipmentItem->precio_unitario;
        // }

        // $lostEquipmentQty = count($lostEquipment);

        
        return view('index', compact(
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

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'dob' => ['required', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->dob = date('Y-m-d', strtotime($request->get('dob')));

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar = '/images/' . $avatarName;
        }
       
        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "User Details Updated successfully!"
            ], 200); // Status code here
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Something went wrong!"
            ], 200); // Status code here
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code 
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Listar los roles disponibles
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Listar los permisos de la aplicación
     */
    public function permissionsList()
    {
        $permissions = Permission::all();
        return view('roles.permissions', compact('permissions'));
    }

    /**
     * Ver el formulario para crear un rol
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Almacenar un rol en la bd
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);

        $role = Role::create([
            'name' => $validated['name']
        ]);

        //Asignamos al rol recien creado los permisos seleccionados.
        $role->permissions()->sync($validated['permissions']);

        return redirect()->route('roles.index')->with('message', "Rol $role->name agregado correctamente");
    }

    /**
     * Ver el formulario para editar un rol
     */
    public function edit($id) 
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $selectedPermissions = DB::table('role_has_permissions')->where('role_id', $role->id)->pluck('permission_id')->all();

        // Traemos los permisos asignados al rol que necesitamos editar
        // $fetchedPermissions = DB::table('role_has_permissions')->select('permission_id')->where('role_id', $role->id)->get();
        // dd($fetchedPermissions);
        // Metemos los valores fetchedPermissions en otro arreglo, es como desestructurarlo 
        // $selectedPermissions = [];
        // foreach ($fetchedPermissions as $key => $value) {
        //     array_push($selectedPermissions, $value->permission_id);
        // }   
        // dd($selectedPermissions);
        
        return view('roles.edit', compact('role', 'permissions', 'selectedPermissions'));
    }

    /**
     * Actualizar un rol en la bd
     */
    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);


        $role = Role::findOrFail($id);
        $role->name = $validated['name'];
        // Agregamos los nuevos permisos al rol
        $role->permissions()->sync($validated['permissions']); 
        $role->save();

        return redirect()->route('roles.index')->with('message', "Rol $role->name actualizado correctamente");
    }

    public function destroy($id) 
    {
        $role = Role::findById($id);
        $role->delete();
        return redirect()->route('roles.index')->with('message', "Rol $role->name eliminado correctamente");
    }
}

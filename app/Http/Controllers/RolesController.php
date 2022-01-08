<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function permissionsList()
    {
        $permissions = Permission::all();
        return view('roles.permissions', compact('permissions'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function roleStore(Request $request)
    {

    }

    public function createUser()
    {
        
    }
}

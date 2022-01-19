<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Asi se creara el usuario master
        $user = new User();
        $user->name = 'Master';
        $user->email = 'master@gmail.com';
        $user->password = Hash::make(123456);
        $user->dob = date('Y-m-d');
        $user->save();

        //Creamos los permisos para los contenedores 
        $permission1 = Permission::create(['name' => 'containers.index', 'description' => 'Ver los contenedores registrados']);
        $permission2 = Permission::create(['name' => 'containers.store', 'description' => 'Registrar un contenedor']);
        $permission3 = Permission::create(['name' => 'containers.create', 'description' => 'Ver formulario para registrar un contenedor, necesario para poder agregar un contenedor']);
        $permission4 = Permission::create(['name' => 'containers.show', 'description' => 'Ver un contenedor en especifico']);
        $permission5 = Permission::create(['name' => 'containers.update', 'description' => 'Ver el formulario para actualizar un contenedor, necesario para poder actualizar un contenedor']);
        $permission6 = Permission::create(['name' => 'containers.destroy', 'description' => 'Eliminar un contenedor']);
        $permission7 = Permission::create(['name' => 'containers.edit', 'description' => 'Actualizar un contenedor']);

        //Creamos los permisos para el equipo de sujeción
        $permission8 = Permission::create(['name' => 'equipment.index', 'description' => 'Ver los equipos de sujeción registrados']);
        $permission9 = Permission::create(['name' => 'equipment.store', 'description' => 'Registrar un equipo de sujeción']);
        $permission10 = Permission::create(['name' => 'equipment.create', 'description' => 'Ver el formulario para registrar un equipo de sujeción, necesario para poder agregar un equipo de sujeción']);
        $permission11 = Permission::create(['name' => 'equipment.show', 'description' => 'Ver un equipo de sujeción en especifico']);
        $permission12 = Permission::create(['name' => 'equipment.update', 'description' => 'Ver el formulario para actualizar un equipo de sujeción, necesario para poder actualizar un equipo de sujeción']);
        $permission13 = Permission::create(['name' => 'equipment.destroy', 'description' => 'Eliminar un equipo de sujeción']);
        $permission14 = Permission::create(['name' => 'equipment.edit', 'description' => 'Actualizar un equipo de sujeción']);

        //Creamos los permisos para los operadores
        $permission15 = Permission::create(['name' => 'operators.index', 'description' => 'Ver los operadores registrados']);
        $permission16 = Permission::create(['name' => 'operators.store', 'description' => 'Registrar un operador']);
        $permission17 = Permission::create(['name' => 'operators.create', 'description' => 'Ver el formulario para registrar un operador, necesario para poder agregar un operador']);
        $permission18 = Permission::create(['name' => 'operators.show', 'description' => 'Ver un operador en especifico']);
        $permission19 = Permission::create(['name' => 'operators.update', 'description' => 'Ver el formulario para actualizar un operador, necesario para poder actualizar un operador']);
        $permission20 = Permission::create(['name' => 'operators.destroy', 'description' => 'Eliminar un operador']);
        $permission21 = Permission::create(['name' => 'operators.edit', 'description' => 'Actualizar un operador']);

        //Creamos los permisos para los proveedores
        $permission22 = Permission::create(['name' => 'providers.index', 'description' => 'Ver los proveedores registrados']);
        $permission23 = Permission::create(['name' => 'providers.store', 'description' => 'Registrar un proveedor']);
        $permission24 = Permission::create(['name' => 'providers.create', 'description' => 'Ver el formulario para registrar un proveedor, necesario para poder agregar un proveedor']);
        $permission25 = Permission::create(['name' => 'providers.show', 'description' => 'Ver un proveedor en especifico']);
        $permission26 = Permission::create(['name' => 'providers.update', 'description' => 'Ver el formulario para actualizar un proveedor, necesario para poder actualizar un proveedor']);
        $permission27 = Permission::create(['name' => 'providers.destroy', 'description' => 'Eliminar un proveedor']);
        $permission28 = Permission::create(['name' => 'providers.edit', 'description' => 'Actualizar un proveedor']);

        //Creamos los permisos para las rutas
        $permission29 = Permission::create(['name' => 'routes.index', 'description' => 'Ver las rutas registradas']);
        $permission30 = Permission::create(['name' => 'routes.store', 'description' => 'Registrar una ruta']);
        $permission31 = Permission::create(['name' => 'routes.create', 'description' => 'Ver el formulario para registrar ruta, , necesario para poder agregar una ruta']);
        $permission32 = Permission::create(['name' => 'routes.show', 'description' => 'Ver una ruta en especifico']);
        $permission33 = Permission::create(['name' => 'routes.update', 'description' => 'Ver el formulario para actualizar una ruta, necesario para poder actualizar una unidad']);
        $permission34 = Permission::create(['name' => 'routes.destroy', 'description' => 'Eliminar una ruta']);
        $permission35 = Permission::create(['name' => 'routes.edit', 'description' => 'Actualizar una ruta']);

        //Creamos los permisos para las unidades
        $permission36 = Permission::create(['name' => 'units.index', 'description' => 'Ver las unidades registradas']);
        $permission37 = Permission::create(['name' => 'units.store', 'description' => 'Registrar una unidad']);
        $permission38 = Permission::create(['name' => 'units.create', 'description' => 'Ver el formulario para registar una unidad, necesario para poder agregar una unidad']);
        $permission39 = Permission::create(['name' => 'units.show', 'description' => 'Ver una unidad en especifico']);
        $permission40 = Permission::create(['name' => 'units.update', 'description' => 'Ver el formulario para actualizar una unidad , necesario para poder actulizar una unidad']);
        $permission41 = Permission::create(['name' => 'units.destroy', 'description' => 'Eliminar una unidad']);
        $permission42 = Permission::create(['name' => 'units.edit', 'description' => 'Actualizar una unidad']);

        //Creamos los permisos para los usuarios
        $permission43 = Permission::create(['name' => 'users.index', 'description' => 'Ver los usuarios registrados']);
        $permission44 = Permission::create(['name' => 'users.store', 'description' => 'Registrar un usuario']);
        $permission45 = Permission::create(['name' => 'users.create', 'description' => 'Ver el formulario para registar usuarios, necesario para poder agregar un usuario']);
        $permission46 = Permission::create(['name' => 'users.show', 'description' => 'Ver un usuario en especifico']);
        $permission47 = Permission::create(['name' => 'users.update', 'description' => 'Ver el formulario para actualizar un usuario , necesario para poder actulizar un usuario']);
        $permission48 = Permission::create(['name' => 'users.destroy', 'description' => 'Eliminar un usuario']);
        $permission49 = Permission::create(['name' => 'users.edit', 'description' => 'Actualizar un usuario']);

        //Creamos los permisos para los roles
        $permission50 = Permission::create(['name' => 'roles.index', 'description' => 'Ver los roles registrados']);
        $permission51 = Permission::create(['name' => 'roles.permissionsList', 'description' => 'Ver los permisos del sistema']);
        $permission52 = Permission::create(['name' => 'roles.create', 'description' => 'Ver el formulario para registar roles, necesario para poder agregar un rol']);
        $permission53 = Permission::create(['name' => 'roles.store', 'description' => 'Registrar un rol']);
        $permission54 = Permission::create(['name' => 'roles.update', 'description' => 'Ver el formulario para actualizar un rol, necesario para poder actulizar un rol']);
        $permission55 = Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar un rol']);
        $permission56 = Permission::create(['name' => 'roles.edit', 'description' => 'Actualizar un rol']);

        //Creamos el rol master
        $role = Role::create(['name' => 'master']);
        $role->syncPermissions([
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $permission5,
            $permission6,
            $permission7,
            $permission8,
            $permission9,
            $permission10,
            $permission11,
            $permission12,
            $permission13,
            $permission14,
            $permission15,
            $permission16,
            $permission17,
            $permission18,
            $permission19,
            $permission20,
            $permission21,
            $permission22,
            $permission23,
            $permission24,
            $permission25,
            $permission26,
            $permission27,
            $permission28,
            $permission29,
            $permission30,
            $permission31,
            $permission32,
            $permission33,
            $permission34,
            $permission35,
            $permission36,
            $permission37,
            $permission38,
            $permission39,
            $permission40,
            $permission41,
            $permission42,
            $permission43,
            $permission44,
            $permission45,
            $permission46,
            $permission47,
            $permission48,
            $permission49,
            $permission50,
            $permission51,
            $permission52,
            $permission53,
            $permission54,
            $permission55,
            $permission56
        ]);

        //Agregamos el rol master al usuario master
        $user->roles()->sync($role->id);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creamos los permisos para los contenedores 
        Permission::create(['name' => 'containers.index']);
        Permission::create(['name' => 'containers.store']);
        Permission::create(['name' => 'containers.create']);
        Permission::create(['name' => 'containers.show']);
        Permission::create(['name' => 'containers.update']);
        Permission::create(['name' => 'containers.destroy']);
        Permission::create(['name' => 'containers.edit']);

        //Creamos los permisos para el equipo de sujeción
        Permission::create(['name' => 'equipment.index']);
        Permission::create(['name' => 'equipment.store']);
        Permission::create(['name' => 'equipment.create']);
        Permission::create(['name' => 'equipment.show']);
        Permission::create(['name' => 'equipment.update']);
        Permission::create(['name' => 'equipment.destroy']);
        Permission::create(['name' => 'equipment.edit']);

        //Creamos los permisos para los operadores
        Permission::create(['name' => 'operators.index']);
        Permission::create(['name' => 'operators.store']);
        Permission::create(['name' => 'operators.create']);
        Permission::create(['name' => 'operators.show']);
        Permission::create(['name' => 'operators.update']);
        Permission::create(['name' => 'operators.destroy']);
        Permission::create(['name' => 'operators.edit']);

        //Creamos los permisos para los proveedores
        Permission::create(['name' => 'providers.index']);
        Permission::create(['name' => 'providers.store']);
        Permission::create(['name' => 'providers.create']);
        Permission::create(['name' => 'providers.show']);
        Permission::create(['name' => 'providers.update']);
        Permission::create(['name' => 'providers.destroy']);
        Permission::create(['name' => 'providers.edit']);

        //Creamos los permisos para las rutas
        Permission::create(['name' => 'routes.index']);
        Permission::create(['name' => 'routes.store']);
        Permission::create(['name' => 'routes.create']);
        Permission::create(['name' => 'routes.show']);
        Permission::create(['name' => 'routes.update']);
        Permission::create(['name' => 'routes.destroy']);
        Permission::create(['name' => 'routes.edit']);

        //Creamos los permisos para las unidades
        Permission::create(['name' => 'units.index']);
        Permission::create(['name' => 'units.store']);
        Permission::create(['name' => 'units.create']);
        Permission::create(['name' => 'units.show']);
        Permission::create(['name' => 'units.update']);
        Permission::create(['name' => 'units.destroy']);
        Permission::create(['name' => 'units.edit']);
    }
}

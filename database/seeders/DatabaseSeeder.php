<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Container;
use App\Models\Operators;
use App\Models\Equipment;
use App\Models\Provider;
use App\Models\Unit;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Operators::factory()->count(50)->create();
        Provider::factory()->count(50)->create();
        Equipment::factory()->count(50)->create();
    }
}

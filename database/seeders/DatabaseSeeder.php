<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Container;
use App\Models\Operators;
use App\Models\Provider;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Container::factory()->count(50)->create();
        Operators::factory()->count(50)->create();
        Provider::factory()->count(50)->create();      
        Unit::factory()->count(50)->create();
        
    }
}

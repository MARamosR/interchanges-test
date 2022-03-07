<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operators;

class OperatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operators::factory()->count(50)->create();
    }
}

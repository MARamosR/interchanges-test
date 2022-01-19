<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'placa' => $this->faker->randomNumber(5, true),
            'marca' => $this->faker->word(),
            'modelo' => $this->faker->word(),
            'status' => 0,
            'anio' => $this->faker->year(),
        ];
    }
}

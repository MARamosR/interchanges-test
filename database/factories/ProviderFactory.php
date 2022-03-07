<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'proveedor' => $this->faker->name(),
            'direccion' => $this->faker->sentence(),
            'ciudad' => $this->faker->text(),
            'telefono' => $this->faker->randomNumber(9, true)
        ];
    }
}

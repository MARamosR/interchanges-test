<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Equipment;

class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {        
        return [
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(3),
            'ubicacion' => $this->faker->sentence(3),
            'precio_unitario' => $this->faker->randomNumber(4, false),
            'activo' => 0,
            'folio' => 'EQP_' . Equipment::getPreviousIdFactory() + 1,
            'id_proveedor' => $this->faker->numberBetween(1, 50)
        ];
    }
}

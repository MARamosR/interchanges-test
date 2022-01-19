<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'serie'          => $this->faker->word(),
            'marca'          => $this->faker->word(),
            'modelo'         => $this->faker->word(),
            'placa'          => $this->faker->word(),
            'comentario'     => $this->faker->text(),
            'placa_mx'       => $this->faker->word(),
            'placa_ant'      => $this->faker->word(),
            'estado'         => $this->faker->name(),
            'riel_logistico' => $this->faker->word(),
            'canastilla'     => $this->faker->word(),
            'tipo_placa'     => $this->faker->word(),
            'status'  => 0,
            'propietario'    => $this->faker->name(),
            'ancho'          => $this->faker->randomNumber(2,true),
            'largo'          => $this->faker->randomNumber(2,true),
            'alto'           => $this->faker->randomNumber(2,true),
            'llanta'         => $this->faker->word(),
            'llanta_status'  => $this->faker->word(),
            'tipo_caja'      => $this->faker->word()
        ];
    }
}

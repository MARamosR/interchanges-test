<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OperatorsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'no_licencia' => $this->faker->text(),
            'tipo_licencia' => $this->faker->text(),
            'fecha_exp' => $this->faker->date(),
            'fecha_venc' => $this->faker->date(),
            'lugar_exp' => $this->faker->name(),
            'antiguedad' => $this->faker->randomDigitNotNull(),
            'iave' => $this->faker->isbn10(),
            'folio' => $this->faker->randomDigitNotNull(),
            'ex_medico' => $this->faker->date()
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre_cargo' => $this->faker->unique()->randomElement(['Representante de Curso', 'Contralor', 'Personero']),
            'descripcion_cargo' => $this->faker->text(100),
        ];
    }
}

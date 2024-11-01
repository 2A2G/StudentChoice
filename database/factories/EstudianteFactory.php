<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_identidad' => $this->faker->unique()->randomNumber(9),
            'nombre_estudiante' => $this->faker->firstName(),
            'apellido_estudiante' => $this->faker->lastName(),
            'sexo' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'curso_id' => $this->faker->randomElement(Curso::pluck('id')->toArray())

        ];
    }
}

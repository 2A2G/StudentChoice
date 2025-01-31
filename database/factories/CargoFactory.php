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
            'descripcion_cargo' => function (array $attributes) {
                switch ($attributes['nombre_cargo']) {
                    case 'Representante de Curso':
                        return 'Es el encargado de representar a su grupo ante el consejo estudiantil, promoviendo la comunicación y el trabajo en equipo entre los estudiantes y los profesores.';
                    case 'Contralor':
                        return 'Su función principal es velar por el uso adecuado de los recursos de la institución, promoviendo la transparencia y la responsabilidad en la gestión estudiantil.';
                    case 'Personero':
                        return 'Tiene como misión ser la voz de los estudiantes ante las directivas, garantizando el respeto por los derechos de los alumnos y fomentando un ambiente de convivencia sana.';
                    default:
                        return 'Descripción no disponible.';
                }
            },
        ];

    }
}

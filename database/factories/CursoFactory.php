<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static $indiceCurso = 0;
    private static $nombresCursos = [
        'Transición',
        'Primero',
        'Segundo',
        'Tercero',
        'Cuarto',
        'Quinto',
        'Sexto',
        'Séptimo',
        'Octavo',
        'Noveno',
        'Décimo',
        'Undécimo'
    ];

    public function definition(): array
    {
        $nombreCurso = self::$nombresCursos[self::$indiceCurso % count(self::$nombresCursos)];
        self::$indiceCurso++;

        return [
            'nombre_curso' => $nombreCurso
        ];
    }
}

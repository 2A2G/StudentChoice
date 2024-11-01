<?php

namespace App\Livewire\Diagramas;

use App\Models\Curso;
use App\Models\Estudiante;
use Livewire\Component;

class Barra extends Component
{
    public $cursosEstudiantes = [];

    public function mount()
    {
        $this->datos();
    }

    public function datos()
    {
        // Obtiene todos los cursos
        $cursos = Curso::whereNull('deleted_at')->pluck('nombre_curso', 'id');

        // Consulta los estudiantes y agrupa por curso
        $cursosConEstudiantes = Estudiante::selectRaw('curso_id, 
        COUNT(*) as cantidad_estudiantes, 
        SUM(CASE WHEN sexo = \'Masculino\' THEN 1 ELSE 0 END) as cantidad_hombres,
        SUM(CASE WHEN sexo = \'Femenino\' THEN 1 ELSE 0 END) as cantidad_mujeres')
            ->whereNull('deleted_at')
            ->whereIn('curso_id', $cursos->keys())
            ->groupBy('curso_id')
            ->get();

        // Combina resultados
        $resultado = $cursosConEstudiantes->map(function ($item) use ($cursos) {
            return [
                'nombre_curso' => $cursos[$item->curso_id] ?? 'Curso desconocido',
                'cantidad_estudiantes' => $item->cantidad_estudiantes,
                'cantidadHombres' => $item->cantidad_hombres,
                'cantidadMujeres' => $item->cantidad_mujeres,
            ];
        })->toArray();

        $this->cursosEstudiantes = $resultado;
    }

    public function render()
    {
        return view('livewire.diagramas.barra', [
            'cursosEstudiantes' => $this->cursosEstudiantes,
        ]);
    }
}

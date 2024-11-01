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
        $cursosConEstudiantes = Estudiante::selectRaw('curso_id, 
        COUNT(*) as cantidad_estudiantes, 
        SUM(CASE WHEN sexo = \'Masculino\' THEN 1 ELSE 0 END) as cantidad_hombres,
        SUM(CASE WHEN sexo = \'Femenino\' THEN 1 ELSE 0 END) as cantidad_mujeres')
            ->where('deleted_at', null)
            ->whereHas('curso', function ($query) {
                $query->where('deleted_at', null);
            })
            ->groupBy('curso_id')
            ->get();

        $resultado = [];
        foreach ($cursosConEstudiantes as $item) {
            $curso = Curso::find($item->curso_id);
            if ($curso) {
                $resultado[] = [
                    'nombre_curso' => $curso->nombre_curso,
                    'cantidad_estudiantes' => $item->cantidad_estudiantes,
                    'cantidadHombres' => $item->cantidad_hombres,
                    'cantidadMujeres' => $item->cantidad_mujeres,
                ];
            }
        }
        $this->cursosEstudiantes = $resultado;
    }

    public function render()
    {
        return view('livewire.diagramas.barra', [
            'cursosEstudiantes' => $this->cursosEstudiantes,
        ]);
    }
}

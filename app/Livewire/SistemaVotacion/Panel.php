<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Curso;
use App\Models\Estudiante;
use Livewire\Component;

class Panel extends Component
{
    public $estadoVotacion = 'activo';
    public $cursoSeleccionado;
    public $cursoGrafica = null;

    public function finalizarVotacion()
    {
        dd('Finalizar votación');
        $this->estadoVotacion = 'inactivo';
    }
    public function iniciarVotacion()
    {
        dd('Iniciar votación');
        $this->estadoVotacion = 'activo';
    }

    public function seleccionarCurso($cursoId)
    {
        $this->cursoSeleccionado = Curso::find($cursoId);
    }

    public function render()
    {
        $estudiantesDisponibles = Estudiante::where('deleted_at', null)->get();
        $cursos = Curso::where('deleted_at', null)->get();
        // dd($cursos);
        return view(
            'livewire.sistema-votacion.panel',
            [
                'estudiantesDisponibles' => $estudiantesDisponibles->count(),
                'cursos' => $cursos,
                'cursoSeleccionado' => $this->cursoSeleccionado,
                'cursoGrafica' => $this->cursoGrafica,

            ]
        );
    }
}

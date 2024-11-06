<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Curso;
use App\Models\Estudiante;
use Livewire\Component;

class Panel extends Component
{
    public $estadoVotacion = 'activo';
    public $estudiantesDisponibles;
    public $cursos;
    public $cursoSeleccionado;

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
    public function estudiantesHabilitados()
    {
        $estudiantesDisponibles = Estudiante::where('deleted_at', null)->get();
        $this->estudiantesDisponibles = $estudiantesDisponibles->count();
    }
    public function cursos()
    {
        $cursos = Curso::where('deleted_at', null)->get();
        $this->cursos = $cursos;
    }

    public function seleccionarCurso($cursoId)
    {
        $this->cursoSeleccionado = Curso::find($cursoId);
    }

    public function render()
    {
        $this->estudiantesHabilitados();
        $this->cursos();
        return view(
            'livewire.sistema-votacion.panel',
            [
                'estudiantesDisponibles' => $this->estudiantesDisponibles,
                'cursos' => $this->cursos,
                'cursoSeleccionado' => $this->cursoSeleccionado,
            ]
        );
    }
}

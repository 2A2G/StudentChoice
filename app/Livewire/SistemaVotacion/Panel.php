<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\opcionesEstudiante;
use Livewire\Attributes\On;
use Livewire\Component;
use OpenSSLCertificate;

class Panel extends Component
{
    public $estadoVotacion = 'activo';
    public $openCurso = false;

    public $estudiantesDisponibles;
    public $cursos;
    public $cursoSeleccionado;
    public $totalNoBlanco;
    public $totalVotosBlanco;

    public function iniciarVotacion()
    {
        dd('Iniciar votación');
        $this->estadoVotacion = 'activo';
    }
    public function finalizarVotacion()
    {
        dd('Finalizar votación');
        $this->estadoVotacion = 'inactivo';
    }
    public function estudiantesHabilitados()
    {
        $this->estudiantesDisponibles = Estudiante::where('deleted_at', null)->count();
    }
    public function cursos()
    {
        $this->cursos = Curso::where('deleted_at', null)->get();
    }
    public function seleccionarCurso($cursoId)
    {
        $this->cursoSeleccionado = Curso::find($cursoId);
        $this->dispatch('curso-seleccionado', $this->cursoSeleccionado);
    }


    #[On('modalCurso')]
    public function abirModalCurso($boolean)
    {
        if ($boolean) {
            $this->openCurso = true;
        }

    }
    public function DataVotos()
    {
        // Total de votos blanco
        // $this->totalNoBlanco = opcionesEstudiante::all()->count();

        // Total de votos en blanco
        // $totalVotosBlanco = opcionesEstudiante::where('voto_blanco', operator: true)->count();
        // $this->totalVotosBlanco = $totalVotosBlanco;
    }

    public function render()
    {
        $this->estudiantesHabilitados();
        $this->cursos();
        $this->DataVotos();
        return view(
            'livewire.sistema-votacion.panel',
            [
                'estudiantesDisponibles' => $this->estudiantesDisponibles,
                'cursos' => $this->cursos,
                'cursoSeleccionado' => $this->cursoSeleccionado,
                'totalNoBlanco' => $this->totalNoBlanco,
                'totalVotosBlanco' => $this->totalVotosBlanco
            ]
        );
    }
}

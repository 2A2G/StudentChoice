<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Comicio;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\opcionesEstudiante;
use Livewire\Attributes\On;
use Livewire\Component;

class Panel extends Component
{
    public $estadoVotacion;
    public $openCurso = false;

    public $estudiantesDisponibles;
    public $cursos;
    public $cursoSeleccionado;
    public $totalNoBlanco;
    public $totalVotosBlanco;

    public function mount()
    {
        $comicio = Comicio::where('estado', 'activo')->first();
        if (empty($comicio) || $comicio->estado_eleccion !== false) {
            $this->estadoVotacion = $comicio->estado_eleccion;
        } else {
            $this->estadoVotacion = false;
        }
    }
    public function iniciarVotacion()
    {
        try {
            $comicio = Comicio::where('estado', 'activo')->first();
            $comicio->update([
                'estado_eleccion' => true
            ]);

            // $this->dispatch('post-created', name: "Se ha activado el comicio " . $comicio->nombre_eleccion);
            $this->mount();

        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "Error al intentar activar el comicio" . $comicio->nombre_eleccion);
        }
    }
    public function finalizarVotacion()
    {
        try {
            $comicio = Comicio::where('estado', 'activo')->first();
            $comicio->update([
                'estado_eleccion' => false
            ]);

            // $this->dispatch('post-created', name: "Se ha finalizado el comicio " . $comicio->nombre_eleccion);
            $this->mount();

        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "Error al intentar finalizar el comicio" . $comicio->nombre_eleccion);
        }
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
        $this->totalNoBlanco = opcionesEstudiante::all()->count();

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

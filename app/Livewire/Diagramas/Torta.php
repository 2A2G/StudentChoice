<?php

namespace App\Livewire\Diagramas;

use App\Livewire\Invitado\Estudiante;
use App\Models\Postulante;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Torta extends Component
{
    public $cursoSeleccionado;

    public function mount($curso)
    {
        $dataCurso = Postulante::with('estudiante')
            ->whereHas('estudiante.curso', function ($query) use ($curso) {
                $query->where('id', $curso->id);
            })->get();

        $this->cursoSeleccionado = $dataCurso;
    }
    public function render()
    {
        return view('livewire.diagramas.torta', [
            'curso' => $this->cursoSeleccionado
        ]);
    }
}

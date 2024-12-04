<?php

namespace App\Livewire\Invitado;

use App\Models\Postulante;
use Livewire\Attributes\On;
use Livewire\Component;

class Votacion extends Component
{
    public $selectedCandidato = null;
    public $dataEstudinate = null;
    public $postulantes;

    #[On('estudiante-votador')]
    public function dataVotador(Estudiante $estudianteVotador)
    {
        $this->dataEstudinate = $estudianteVotador;
    }

    public function updatedDataEstudinate()
    {
        if ($this->dataEstudinate) {
            dd($this->dataEstudinate);
        }
    }

    public function mount()
    {
        $this->postulantes = Postulante::all();
    }

    public function selectCandidato($candidatoId)
    {
        $this->selectedCandidato = ($this->selectedCandidato === $candidatoId) ? null : $candidatoId;
    }

    public function votar()
    {
        try {

            if ($this->selectedCandidato) {

                dd($this->selectedCandidato);

            } else {
                $this->dispatch('post-warning', name: 'Intentelo de nuevo, hubo un error realizar el proceso de votación');
            }
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: 'Intentelo de nuevo, hubo un error realizar el proceso de votación');
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.invitado.votacion');
    }
}

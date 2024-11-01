<?php

namespace App\Livewire\Invitado;

use App\Models\Postulante;
use Livewire\Component;

class Votacion extends Component
{
    public $selectedCandidato = null;
    public $postulantes;

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
        if ($this->selectedCandidato) {
            $candidato = Postulante::find($this->selectedCandidato);
            dd($candidato);           
        }
    }

    public function render()
    {
        $postulantes = Postulante::all();
        return view('livewire.invitado.votacion', compact('postulantes'));
    }
}

<?php

namespace App\Livewire\Invitado;

use Livewire\Component;

class Votacion extends Component
{
    public $postulantes;


    public function render()
    {
        return view('livewire.invitado.votacion');
    }
}

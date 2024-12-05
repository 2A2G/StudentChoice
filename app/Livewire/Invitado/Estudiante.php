<?php

namespace App\Livewire\Invitado;

use Livewire\Attributes\Validate;
use Livewire\Component;


class Estudiante extends Component
{
    #[Validate('required')]
    #[Validate("unique:estudiantes,numero_identidad")]
    public $open = false;
    public $numero_identidad;


    public function clearInput()
    {
        $this->numero_identidad = '';
    }


    public function render()
    {
        return view('livewire.invitado.estudiante');
    }
}

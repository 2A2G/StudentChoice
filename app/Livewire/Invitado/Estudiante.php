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


    public function buscarEstudiante()
    {
        try {
            $estudiante = \App\Models\Estudiante::where('numero_identidad', $this->numero_identidad)->first();
            if ($estudiante) {

                return view('livewire.invitado.dashboard', compact('estudiante'));
            } else {
                $this->dispatch('post-error', name: "No se encontro el estudiante o no esta registrado. Intenta de nuevo");
            }

            $this->open = false;
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "No se encontro el estudiante o no esta registrado. Intenta de nuevo");

        }

        $this->clearInput();

    }
    public function render()
    {
        return view('livewire.invitado.estudiante');
    }
}

<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    public $caso;
    #[On('cambiarComponent')]


    public $name;

    public function cambiar($name)
    {
        $this->caso = $name;
    }



    public function render()
    {
        return view('livewire.dashboard');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class SidebarMenu extends Component
{
    // public function cambiar($name)
    // {
    //     $this->dispatch('cambiarComponent', $name);
    // }

    public function render()
    {
        return view('livewire.sidebar-menu');
    }
}

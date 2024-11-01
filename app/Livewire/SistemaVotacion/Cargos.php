<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Cargo;
use Livewire\Component;

class Cargos extends Component
{

    public $open = false;
    public $nombre_cargo;
    public $descripcion_cargo;

    public function clearInput()
    {
        $this->nombre_cargo = '';
        $this->descripcion_cargo = '';
    }

    public function cambiar()
    {
        $this->open = true;
    }

    public function store()
    {
        $this->validate(
            [
                'nombre_cargo' => 'required',
                'descripcion_cargo' => 'required'
            ]
        );

        Cargo::create(
            [
                'nombre_cargo' => $this->nombre_cargo,
                'descripcion_cargo' => $this->descripcion_cargo
            ]
        );

        $this->dispatch('post-created', name: "El cargo " . $this->nombre_cargo . ", creado satisfactoriamente");
        $this->clearInput();
        $this->open = false;
    }



    public function render()
    {
        $cargos = Cargo::count();
        return view(
            'livewire.sistema-votacion.cargos',
            [
                'cargos' => $cargos
            ]
        );
    }
}

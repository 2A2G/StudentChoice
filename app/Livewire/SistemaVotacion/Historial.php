<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Choice;
use App\Models\Comicio;
use App\Models\Eleccion;
use App\Models\Postulante;
use Livewire\Component;

class Historial extends Component
{

    public $open = false;

    public $nombre_eleccion;

    public $estado = '';

    public function clearInput()
    {
        $this->nombre_eleccion = '';
        $this->estado = '';
    }

    public function openModal()
    {
        $this->clearInput();
        $this->open = true;
    }

    public function store()
    {
        $this->validate([
            'nombre_eleccion' => 'required|string',
        ]);

        try {
            Comicio::create([
                'nombre_eleccion' => $this->nombre_eleccion,
            ]);

            $this->dispatch('post-created', name: "La elección " . $this->nombre_eleccion . ", creado satisfactoriamente");
            $this->clearInput();
            $this->open = false;

        } catch (\Throwable $th) {
            return $th;
        }
    }



    public function render()
    {
        $totalPostulantesAnios = Postulante::all()->count();
        return view(
            'livewire.sistema-votacion.historial',
            [
                'totalPostulantesAnios' => $totalPostulantesAnios
            ]
        );
    }
}

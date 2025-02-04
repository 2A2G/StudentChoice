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
            $comicio = Comicio::where('estado', true)->first();

            if ($comicio) {
                $this->dispatch('post-warning', name: "No se puede crear una nueva elección, ya que hay una elección activa");
            } else {
                $comicio = Comicio::create([
                    'nombre_eleccion' => $this->nombre_eleccion,
                    'estado' => true,
                ]);

                $this->dispatch('post-created', name: "La elección " . $this->nombre_eleccion . " ha sido creada satisfactoriamente");
            }

            $this->clearInput();
            $this->open = false;

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function showResults($comcioId)
    {
        return redirect()->route('viewResultados', ['comicioId' => $comcioId]);
    }


    public function render()
    {
        $totalPostulantesAnios = Postulante::all()->count();
        $comicioData = Comicio::getComicio(10);

        return view(
            'livewire.sistema-votacion.historial',
            [
                'totalPostulantesAnios' => $totalPostulantesAnios,
                'comicioData' => $comicioData,
            ]
        );
    }
}

<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Choice;
use App\Models\Comicio;
use App\Models\Eleccion;
use App\Models\Postulante;
use Livewire\Component;
use Livewire\WithPagination;

class Historial extends Component
{
    use WithPagination;

    public $open = false;
    public $openFilter = false;
    public $nombre_eleccion;
    public $estado = '';
    public $totalPostulantesAnios;
    public $filterComicio = [];

    public function mount()
    {
        $this->totalPostulantesAnios = Comicio::all()->count();
    }

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

    public function filter()
    {
        $this->clearInput();
        $this->openFilter = true;
    }

    public function searchComicios()
    {
        if (empty($this->nombre_eleccion) && empty($this->estado)) {
            $this->dispatch('post-warning', name: "Debe ingresar al menos un campo para filtrar");
            return;
        }

        $this->filterComicio = [
            'nombre_eleccion' => $this->nombre_eleccion,
            'estado' => $this->estado,
        ];

        $this->openFilter = false;
    }

    public function render()
    {
        $query = Comicio::with('postulante')
            ->withTrashed()
            ->withCount('postulante');

        if (!empty($this->filterComicio)) {
            $query->comicio($this->filterComicio);
        }

        return view(
            'livewire.sistema-votacion.historial',
            [
                'comicioData' => $query->paginate(10),
            ]
        );
    }
}

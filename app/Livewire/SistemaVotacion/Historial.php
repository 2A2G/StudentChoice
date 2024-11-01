<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Postulante;
use Livewire\Component;

class Historial extends Component
{

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

<?php

namespace App\Livewire\Diagramas;

use App\Models\Postulante;
use Livewire\Attributes\On;
use Livewire\Component;

class Torta extends Component
{
    public $cursoSeleccionado;
    public $postulantesCurso = null;
    public $graficaDatos = [];

    protected $listeners = ['curso-seleccionado' => 'dataCursoPostulante'];

    public function dataCursoPostulante($curso_id)
    {
        $this->cursoSeleccionado = $curso_id;

        $this->postulantesCurso = Postulante::with(['estudiante', 'votos'])
            ->whereHas('estudiante.curso', function ($query) use ($curso_id) {
                $query->where('id', $curso_id);
            })
            ->get();


        $this->graficaDatos = $this->postulantesCurso->map(function ($postulante) {
            return [
                'nombre' => $postulante->estudiante->nombre_estudiante ?? 'Desconocido',
                'cantidad_votos' => $postulante->votos->sum('cantidad_voto'),
                'voto_blanco' => $postulante->votos->sum('voto_blanco'),
            ];
        });
    }

    public function render()
    {
        return view('livewire.diagramas.torta', [
            'graficaDatos' => $this->graficaDatos,
        ]);
    }
}

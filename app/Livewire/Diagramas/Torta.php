<?php

namespace App\Livewire\Diagramas;

use App\Models\Curso;
use App\Models\Postulante;
use App\Models\Votos;
use Livewire\Attributes\On;
use Livewire\Component;

class Torta extends Component
{
    public $cursoSeleccionado;
    public $postulantesCurso = null;
    public $graficaDatos = [];

    #[On('curso-seleccionado')]
    public function dataCurso(Curso $dataCursoPostulante)
    {
        $this->dataCursoPostulante($dataCursoPostulante->id);
    }

    public function dataCursoPostulante($curso_id)
    {
        $this->cursoSeleccionado = $curso_id;

        $this->postulantesCurso = Postulante::whereHas('estudiante', function ($query) use ($curso_id) {
            $query->where('curso_id', $curso_id);
        })->with(['estudiante', 'votos'])->get();

        if ($this->postulantesCurso->isEmpty()) {
            $this->dispatch('post-warning', name: 'No hay datos para mostrar para este curso');
            $this->dispatch('modalCurso', false);
            return;
        }

        $datosPostulantes = $this->postulantesCurso->map(function ($postulante) {
            return [
                'nombre' => $postulante->estudiante->nombre_estudiante ?? 'Desconocido',
                'cantidad_votos' => $postulante->votos->sum('cantidad_voto'),
            ];
        });
        $votosEnBlanco = [
            [
                'nombre' => 'Voto en blanco',
                'cantidad_votos' => Votos::where('cargo_id', $this->postulantesCurso->first()->cargo_id)->pluck('votos_en_blanco')->first() ?? 0
            ]
        ];

        $this->graficaDatos = array_merge($datosPostulantes->toArray(), $votosEnBlanco);
        $this->dispatch('modalCurso', true);
        $this->dispatch('grafico', data: $this->graficaDatos);

    }

    public function render()
    {
        return view('livewire.diagramas.torta', [
            'graficaDatos' => $this->graficaDatos,
        ]);
    }
}

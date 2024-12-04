<?php

namespace App\Livewire\Diagramas;

use App\Models\Curso;
use App\Models\Postulante;
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

        $datosPostulantes = $this->postulantesCurso->map(function ($postulante) {
            return [
                'nombre' => $postulante->estudiante->nombre_estudiante ?? 'Desconocido',
                'cantidad_votos' => $postulante->votos->sum('cantidad_voto'),
            ];
        });
        $votosEnBlanco = [
            [
                'nombre' => 'Voto en blanco',
                'cantidad_votos' => $this->postulantesCurso->flatMap(function ($postulante) {
                    return $postulante->votos;
                })->sum('votos_en_blanco'),
            ]
        ];

        $this->graficaDatos = array_merge($datosPostulantes->toArray(), $votosEnBlanco);
        $this->dispatch('grafico', data: $this->graficaDatos);
    }

    public function render()
    {
        return view('livewire.diagramas.torta', [
            'graficaDatos' => $this->graficaDatos,
        ]);
    }
}

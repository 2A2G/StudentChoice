<?php

namespace App\Livewire\Invitado;

use App\Livewire\SistemaVotacion\Cargos;
use App\Models\Cargo;
use App\Models\Comicio;
use App\Models\Estudiante;
use App\Models\opcionesEstudiante;
use App\Models\Postulante;
use App\Models\PostulanteCurso;
use App\Models\Votos;
use Livewire\Attributes\On;
use Livewire\Component;

class Votacion extends Component
{
    public $selectedCandidato = null;
    public $dataEstudinate = null;
    public $estudiante = null;
    public $postulantes = [];
    public $candidatos;
    public $paginaActual = 0;


    #[On('estudiante-votador')]
    public function dataVotador(Estudiante $estudianteVotador)
    {
        $this->dataEstudinate = $estudianteVotador;
    }

    public function updatedDataEstudinate()
    {
        if ($this->dataEstudinate) {
        }
    }

    public function mount($estudiante)
    {
        $this->estudiante = $estudiante;

        $comicio = Comicio::where('estado', 'activo')->first();

        if (!$comicio) {
            $this->postulantes = [];
            return;
        }

        $this->postulantes = PostulanteCurso::with('postulante')->where('curso_id', $this->estudiante->curso_id)->get();

        // dd($this->postulantes[0]->postulante);
        $votosEstudiante = OpcionesEstudiante::where('estudiante_id', $this->estudiante->id)
            ->where('comicio_id', $comicio->id)->pluck('cargo_id')->toArray();

        $this->postulantes = collect($this->postulantes)->filter(function ($postulante) use ($votosEstudiante) {
            return !in_array($postulante->postulante->cargo_id, $votosEstudiante);
        });

        $this->candidatos = collect($this->postulantes)->groupBy(function ($postulante) {
            return $postulante->postulante->cargo->nombre_cargo;
        });
    }

    public function paginaSiguiente()
    {
        if ($this->paginaActual < count($this->candidatos) - 1) {
            $this->paginaActual++;
        }
    }

    public function paginaAnterior()
    {
        if ($this->paginaActual > 0) {
            $this->paginaActual--;
        }
    }



    public function selectCandidato($candidatoId)
    {
        $this->selectedCandidato = ($this->selectedCandidato === $candidatoId) ? null : $candidatoId;
    }

    public function votar()
    {
        try {
            if ($this->selectedCandidato) {

                // $this->postulante->where()
                $postulante = Postulante::find($this->selectedCandidato);
                if ($postulante) {
                    $cargo = $postulante->cargo_id;
                }

                if (is_null($cargo)) {
                    throw new \Exception("El cargo es inválido.");
                }

                // Votar en blanco
                if ($this->selectedCandidato === 'voto_en_blanco') {
                    $cargoVotar = Votos::where('cargo_id', $cargo)->first();

                    if ($cargoVotar) {
                        $cargoVotar->update([
                            'votos_en_blanco' => $cargoVotar->votos_en_blanco + 1
                        ]);
                    } else {
                        Votos::create([
                            'cargo_id' => $cargo,
                            'votos_en_blanco' => 1,
                        ]);
                    }

                    opcionesEstudiante::create([
                        'estudiante_id' => $this->estudiante->id,
                        'cargo_id' => $cargo,
                    ]);

                    $this->dispatch('post-created', name: 'Has votado en blanco correctamente');
                } else {
                    $votoExistente = Votos::where('postulante_id', $this->selectedCandidato)
                        ->where('cargo_id', $cargo)
                        ->first();

                    if ($votoExistente) {
                        $votoExistente->update([
                            'cantidad_voto' => $votoExistente->cantidad_voto + 1
                        ]);
                    } else {
                        Votos::create([
                            'postulante_id' => $this->selectedCandidato,
                            'cargo_id' => $cargo,
                            'cantidad_voto' => 1,
                        ]);
                    }

                    opcionesEstudiante::create([
                        'estudiante_id' => $this->estudiante->id,
                        'cargo_id' => $cargo,
                    ]);

                    $this->dispatch('post-created', name: 'Has votado por un postulante correctamente');
                }
            } else {
                $this->dispatch('post-warning', name: 'Intentelo de nuevo, hubo un error al realizar el proceso de votación');
            }
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: 'Intentelo de nuevo, hubo un error al realizar el proceso de votación');
            throw $th;
        }
    }


    public function render()
    {
        return view('livewire.invitado.votacion');
    }
}

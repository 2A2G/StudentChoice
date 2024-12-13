<?php

namespace App\Livewire\Invitado;

use App\Livewire\SistemaVotacion\Cargos;
use App\Models\Cargo;
use App\Models\Estudiante;
use App\Models\opcionesEstudiante;
use App\Models\Postulante;
use App\Models\Votos;
use Livewire\Attributes\On;
use Livewire\Component;

class Votacion extends Component
{
    public $selectedCandidato = null;
    public $dataEstudinate = null;
    public $estudiante = null;

    public $postulantes = [];
    public $representanteCursos = null;
    public $contralores = null;
    public $personeros = null;

    public $vctos = [];

    #[On('estudiante-votador')]
    public function dataVotador(Estudiante $estudianteVotador)
    {
        $this->dataEstudinate = $estudianteVotador;
    }

    public function updatedDataEstudinate()
    {
        if ($this->dataEstudinate) {
            dd($this->dataEstudinate);
        }
    }

    public function mount($estudiante)
    {
        $this->estudiante = $estudiante;

        $this->postulantes = [];

        // Representante de curso
        if (
            !opcionesEstudiante::where('cargo_id', Cargo::representanteCurso)
                ->where('estudiante_id', $this->estudiante->id)
                ->where('is_active', false)
                ->exists()
        ) {
            $this->representanteCursos = Postulante::with('estudiante')
                ->whereHas('estudiante', function ($query) {
                    $query->where('curso_id', $this->estudiante->curso_id)
                        ->where('cargo_id', Cargo::representanteCurso);
                })->paginate(10); // Paginación
            $this->postulantes[0] = $this->representanteCursos; // Guardar en el índice 0

        }

        // Contralor
        if (
            !opcionesEstudiante::where('cargo_id', Cargo::contralor)
                ->where('estudiante_id', $this->estudiante->id)
                ->where('is_active', false)
                ->exists()
        ) {
            $this->contralores = Postulante::where('cargo_id', Cargo::contralor)->paginate(10); // Paginación
            $this->postulantes[1] = $this->contralores; // Guardar en el índice 1

        }

        // Personero
        if (
            !opcionesEstudiante::where('cargo_id', Cargo::personero)
                ->where('estudiante_id', $this->estudiante->id)
                ->where('is_active', false)
                ->exists()
        ) {
            $this->personeros = Postulante::where('cargo_id', Cargo::personero)->paginate(10); // Paginación

            $this->postulantes[2] = $this->personeros; // Guardar en el índice 2

        }
        dd($this->postulantes);
    }


    public function selectCandidato($candidatoId)
    {
        $this->selectedCandidato = ($this->selectedCandidato === $candidatoId) ? null : $candidatoId;
        // dd($this->selectedCandidato);
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

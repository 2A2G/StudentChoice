<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\opcionesEstudiante;
use App\Models\Postulante;
use App\Models\Votos;
use Illuminate\Support\Collection;

class VotacionService
{
    public function calcularResultadosPorCargo(Cargo $cargo, $filtro = null, $comicioId): Collection
    {
        $votos = Votos::where('cargo_id', $cargo->id);

        if ($filtro) {
            $votos = $votos->whereHas('postulante', function ($query) use ($filtro) {
                $query->where($filtro);
            });
        }

        $votos = $votos->get()->groupBy('postulante_id')
            ->map(fn($grupo) => $grupo->sum('cantidad_voto'))
            ->sortDesc();

        $maxVotos = $votos->first();
        $ganadores = $votos->filter(fn($votos) => $votos === $maxVotos)->keys();

        $ganadoresPostulantes = Postulante::whereIn('id', $ganadores)->where('comicio_id', $comicioId)->get();

        return $ganadoresPostulantes->map(function ($ganador) use ($votos) {
            return [
                'nombre' => $ganador->estudiante->nombre_estudiante . ' ' . $ganador->estudiante->apellido_estudiante ?? 'Nombre no disponible',
                'votos' => $votos[$ganador->id],
            ];
        });
    }

    public function calcularGanadoresPorCurso(Cargo $cargo, $curso, $comicioId): ?array
    {
        $representantes = Votos::where('cargo_id', $cargo->id)
            ->whereHas('postulante', function ($query) use ($curso, $comicioId) {
                $query->where('curso_id', $curso->id)
                    ->where('comicio_id', $comicioId);
            })
            ->orderBy('cantidad_voto', 'desc')
            ->get();

        if ($representantes->isEmpty()) {
            return null;
        }

        $maxVotos = $representantes->first()->cantidad_voto;
        $ganadores = $representantes->filter(function ($representante) use ($maxVotos) {
            return $representante->cantidad_voto == $maxVotos;
        });

        return $ganadores->map(function ($ganador) {
            $nombreCompleto = $ganador->postulante->estudiante->nombre_estudiante
                . ' '
                . $ganador->postulante->estudiante->apellido_estudiante
                ?? 'Nombre no disponible';

            return [
                'nombre' => $nombreCompleto,
                'votos' => $ganador->cantidad_voto,
            ];
        })->toArray();
    }

    public function estudiantesSinVotarPorCurso()
    {
        $cursos = Curso::all();
        $votos = OpcionesEstudiante::all();
        $resultado = [];

        foreach ($cursos as $curso) {
            $estudiantesDelCurso = Estudiante::where('curso_id', $curso->id)->get();

            $sinVotar = $estudiantesDelCurso->filter(function ($estudiante) use ($votos) {
                return !$votos->where('estudiante_id', $estudiante->id)->first();
            })->count();

            $resultado[] = [
                'curso_id' => $curso->id,
                'sinVotar' => $sinVotar,
            ];
        }
        return $resultado;
    }
}

<?php

namespace App\Http\Controllers;

use App\Livewire\SistemaVotacion\Cargos;
use App\Models\Cargo;
use App\Models\Curso;
use App\Models\Postulante;
use App\Models\Votos;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function generarBoletin()
    {
        $nameInstitucion = env('NAME_INSTITUCION', 'Nombre de la Institución');
        $fechaComicios = '2025-02-10';

        $cursos = Curso::with(['estudiantes', 'postulante'])->get();
        $postulantes = Postulante::with('cargo')->get();
        $votos = Votos::all();

        $normas = [
            [
                'titulo' => 'Ley General de Educación (Ley 115 de 1994)',
                'descripcion' => 'Regula la participación democrática en las instituciones educativas, promoviendo la formación ciudadana de los estudiantes.'
            ],
            [
                'titulo' => 'Decreto 1860 de 1994',
                'descripcion' => 'Establece los lineamientos para la elección de Personeros Estudiantiles, Representantes de Curso y otros órganos de gobierno escolar.'
            ]
        ];

        $cargos = Cargo::all();
        $cargoRepresenteCurso = Cargo::where('nombre_cargo', 'Representante de Curso')->first();
        $cargoContralor = Cargo::where('nombre_cargo', 'Contralor')->first();
        $cargoPersonero = Cargo::where('nombre_cargo', 'Personero')->first();

        $cursos = Curso::with('estudiantes')->get();
        $resultados = [
            'representantes' => [],
            'contralor' => [],
            'personero' => []
        ];

        // Ganadores para Representante de cada Curso
        foreach ($cursos as $curso) {
            $representantes = Votos::where('cargo_id', $cargoRepresenteCurso->id)
                ->whereHas('postulante', function ($query) use ($curso) {
                    $query->where('curso_id', $curso->id);
                })
                ->orderBy('cantidad_voto', 'desc')
                ->get();

            if ($representantes->isEmpty()) {
                continue;
            }

            $maxVotos = $representantes->first()->cantidad_voto;
            $ganadores = $representantes->filter(function ($representante) use ($maxVotos) {
                return $representante->cantidad_voto == $maxVotos;
            });

            foreach ($ganadores as $ganador) {
                $cursoNombre = $curso->nombre_curso;
                if (!isset($resultados['representantes'][$cursoNombre])) {
                    $resultados['representantes'][$cursoNombre] = [];
                }

                $resultados['representantes'][$cursoNombre][] = [
                    'nombre' => $ganador->postulante->estudiante->nombre_estudiante . ' ' . $ganador->postulante->estudiante->apellido_estudiante ?? 'Nombre no disponible',
                    'votos' => $ganador->cantidad_voto,
                ];
            }
        }

        // Contralor
        $votosContralor = Votos::where('cargo_id', $cargoContralor->id)
            ->get()
            ->groupBy('postulante_id')
            ->map(fn($grupo) => $grupo->sum('cantidad_voto'))
            ->sortDesc();

        $maxVotosContralor = $votosContralor->first();
        $ganadoresContralor = $votosContralor->filter(fn($votos) => $votos === $maxVotosContralor)->keys();


        foreach (Postulante::whereIn('id', $ganadoresContralor)->get() as $ganador) {
            $resultados['contralor'][] = [
                'nombre' => $ganador->estudiante->nombre_estudiante . ' ' . $ganador->estudiante->apellido_estudiante ?? 'Nombre no disponible',
                'votos' => $votosContralor[$ganador->id],
            ];
        }


        // Calcular ganador para Personero
        $votosPersonero = Votos::where('cargo_id', $cargoPersonero->id)
            ->get()
            ->groupBy('postulante_id')
            ->map(fn($grupo) => $grupo->sum('cantidad_voto'))
            ->sortDesc();

        $maxVotosPersonero = $votosPersonero->first();
        $ganadoresPersonero = $votosPersonero->filter(fn($votos) => $votos === $maxVotosPersonero)->keys();

        foreach ($ganadoresPersonero as $ganadorId) {
            $ganador = Postulante::find($ganadorId);
            $resultados['personero'][] = [
                'nombre' => $ganador->estudiante->nombre_estudiante . ' ' . $ganador->estudiante->apellido_estudiante ?? 'Nombre no disponible',
                'votos' => $votosPersonero[$ganadorId],
            ];
        }

        // dd($resultados)['personero'];

        return view('certifcate.constancia', compact('nameInstitucion', 'fechaComicios', 'normas', 'cargos', 'cursos', 'postulantes', 'votos', 'resultados'));
    }



}

<?php

namespace App\Http\Controllers;

use App\Livewire\SistemaVotacion\Cargos;
use App\Models\Cargo;
use App\Models\Curso;
use App\Models\Estudiante;
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

        // Calcular ganadores para Representantes de Curso
        foreach ($cursos as $curso) {
            $votosCurso = Votos::where('cargo_id', $cargoRepresenteCurso->id)
                ->whereHas('postulante', function ($query) use ($curso) {
                    $query->where('curso_id', $curso->id); // Filtrar postulantes por curso
                })
                ->with('postulante') // Traer datos del postulante
                ->get()
                ->groupBy('postulante_id')
                ->map(function ($grupo) {
                    return $grupo->sum('cantidad_voto');
                })
                ->sortDesc();

            $maxVotos = $votosCurso->first(); // Máxima cantidad de votos
            $ganadores = $votosCurso->filter(fn($votos) => $votos === $maxVotos)->keys(); // Postulantes con máximo de votos

            $resultados['representantes'][$curso->nombre] = [
                'ganadores' => Postulante::whereIn('id', $ganadores)->get(),
                'empate' => $ganadores->count() > 1
            ];
        }


        dd($resultados);

        // Calcular ganador para Contralor
        $votosContralor = Votos::where('cargo_id', $cargoContralor->id)
            ->get()
            ->groupBy('postulante_id')
            ->map(fn($grupo) => $grupo->sum('cantidad_voto'))
            ->sortDesc();

        $maxVotosContralor = $votosContralor->first();
        $ganadoresContralor = $votosContralor->filter(fn($votos) => $votos === $maxVotosContralor)->keys();

        $resultados['contralor'] = [
            'ganadores' => Postulante::whereIn('id', $ganadoresContralor)->get(),
            'empate' => $ganadoresContralor->count() > 1
        ];

        // Calcular ganador para Personero
        $votosPersonero = Votos::where('cargo_id', $cargoPersonero->id)
            ->get()
            ->groupBy('postulante_id')
            ->map(fn($grupo) => $grupo->sum('cantidad_voto'))
            ->sortDesc();

        $maxVotosPersonero = $votosPersonero->first();
        $ganadoresPersonero = $votosPersonero->filter(fn($votos) => $votos === $maxVotosPersonero)->keys();

        $resultados['personero'] = [
            'ganadores' => Postulante::whereIn('id', $ganadoresPersonero)->get(),
            'empate' => $ganadoresPersonero->count() > 1
        ];


        return view('certifcate.constancia', compact('nameInstitucion', 'fechaComicios', 'normas', 'cargos', 'cursos', 'postulantes', 'votos', 'resultados'));
    }



}

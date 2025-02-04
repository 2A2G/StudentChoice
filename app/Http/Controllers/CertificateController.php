<?php

namespace App\Http\Controllers;

use App\Services\VotacionService;
use App\Models\Curso;
use App\Models\Cargo;
use App\Models\Postulante;
use App\Models\Votos;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    protected $votacionService;

    public function __construct(VotacionService $votacionService)
    {
        $this->votacionService = $votacionService;
    }

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

        $resultados = [
            'representantes' => [],
            'contralor' => [],
            'personero' => []
        ];

        foreach ($cursos as $curso) {
            $ganadoresRepresentante = $this->votacionService->calcularGanadoresPorCurso($cargoRepresenteCurso, $curso);

            if ($ganadoresRepresentante) {
                $resultados['representantes'][$curso->nombre_curso] = $ganadoresRepresentante;
            }
        }

        // Contralor
        $ganadoresContralor = $this->votacionService->calcularResultadosPorCargo($cargoContralor);

        if ($ganadoresContralor->isNotEmpty()) {
            $resultados['contralor'] = $ganadoresContralor->toArray();
        }

        // Personero
        $ganadoresPersonero = $this->votacionService->calcularResultadosPorCargo($cargoPersonero);

        if ($ganadoresPersonero->isNotEmpty()) {
            $resultados['personero'] = $ganadoresPersonero->toArray();
        }

        // Retornamos la vista
        return view('certifcate.constancia', compact('nameInstitucion', 'fechaComicios', 'normas', 'cargos', 'cursos', 'postulantes', 'votos', 'resultados'));
    }

}

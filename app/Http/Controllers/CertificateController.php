<?php
namespace App\Http\Controllers;

use App\Services\VotacionService;
use App\Models\Curso;
use App\Models\Cargo;
use App\Models\Postulante;
use App\Models\Votos;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    protected $votacionService;

    public function __construct(VotacionService $votacionService)
    {
        $this->votacionService = $votacionService;
    }

    public function generarBoletin($comicioId)
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
            $ganadoresRepresentante = $this->votacionService->calcularGanadoresPorCurso($cargoRepresenteCurso, $curso, $comicioId);

            if ($ganadoresRepresentante) {
                $resultados['representantes'][$curso->nombre_curso] = $ganadoresRepresentante;
            }
        }

        $ganadoresContralor = $this->votacionService->calcularResultadosPorCargo($cargoContralor, null, $comicioId);

        if ($ganadoresContralor->isNotEmpty()) {
            $resultados['contralor'] = $ganadoresContralor->toArray();
        }

        $ganadoresPersonero = $this->votacionService->calcularResultadosPorCargo($cargoPersonero, null, $comicioId);

        if ($ganadoresPersonero->isNotEmpty()) {
            $resultados['personero'] = $ganadoresPersonero->toArray();
        }
        $estudiantesSinVotar = $this->votacionService->estudiantesSinVotarPorCurso();

        $pdf = Pdf::loadView('certifcate.constancia', compact('nameInstitucion', 'fechaComicios', 'normas', 'cargos', 'cursos', 'postulantes', 'votos', 'resultados', 'estudiantesSinVotar'));

        return $pdf->download('boletin_comicios.pdf');

    }
}

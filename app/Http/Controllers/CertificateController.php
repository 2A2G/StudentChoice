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

        // Cargar los cursos con estudiantes y postulantes en una sola consulta
        $cursos = Curso::with(['estudiantes', 'postulante'])->get();

        // Cargar los postulantes y votos de manera anticipada si es necesario
        $postulantes = Postulante::with('cargo')->get();
        $votos = Votos::all();

        // Cargar las normas y cargos
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

        return view('certifcate.constancia', compact('nameInstitucion', 'fechaComicios', 'normas', 'cargos', 'cursos', 'postulantes', 'votos'));
    }



}

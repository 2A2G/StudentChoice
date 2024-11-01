<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Curso;
use App\Models\Estudiante;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Estudiantes extends Component
{

    #[Validate('required')]
    #[Validate("Unique:estudiantes,numeroIdentidad")]

    public $open = false;

    public $numero_identidad;
    public $nombre_estudiante;
    public $apellido_estudiante;
    public $sexo = '';
    public $curso_id = '';

    public function clearInput()
    {
        $this->numero_identidad = '';
        $this->nombre_estudiante = '';
        $this->apellido_estudiante = '';
        $this->sexo = '';
        $this->curso_id = '';
    }


    public function store()
    {
        $this->validate(
            [
                'numero_identidad' => 'required',
                'nombre_estudiante' => 'required',
                'apellido_estudiante' => 'required',
                'sexo' => 'required',
                'curso_id' => 'required'
            ]
        );

        $estudiante = new Estudiante();
        $estudiante->numero_identidad = $this->numero_identidad;
        $estudiante->nombre_estudiante = $this->nombre_estudiante;
        $estudiante->apellido_estudiante = $this->apellido_estudiante;
        $estudiante->sexo = $this->sexo;
        $estudiante->curso_id = $this->curso_id;
        $estudiante->save();
        $this->dispatch('post-created', name: "El estudiante " . $this->nombre_estudiante . ", creado satisfactoriamente");
        $this->clearInput();
        $this->open = false;
    }

    public function cambiar()
    {
        $this->open = true;
    }
    public function render()
    {

        $totalEstudiantes = Estudiante::count();
        $cursos = Curso::all();
        return view('livewire.super-admin.estudiantes', [
            'totalEstudiantes' => $totalEstudiantes,
            'cursos' => $cursos
        ]);
    }
}

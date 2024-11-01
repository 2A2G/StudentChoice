<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Docentes extends Component
{
    #[Validate('required')]
    #[Validate("Unique:docentes,numero_identidad")]

    public $open = false;
    public $name;
    public $numero_identidad;
    public $name_docente;
    public $email;
    public $sexo = '';
    public $asignatura = '';
    public $curso_id = null;

    public function clearInput()
    {
        $this->name = '';
        $this->email = '';
        $this->numero_identidad = '';
        $this->name_docente = '';
        $this->sexo = '';
        $this->asignatura = '';
        $this->curso_id = null;
    }

    public function store()
    {
        $this->validate(
            [
                'name_docente' => 'required',
                'email' => 'required|email',
                'numero_identidad' => 'required',
                'sexo' => 'required',
                'asignatura' => 'required'
            ]
        );

        $userDocente = new User();
        $docente = new Docente();

        $userDocente->name = $this->name_docente;
        $userDocente->email = $this->email;
        $userDocente->password = bcrypt('password');
        $userDocente->assignRole('docente');
        $userDocente->save();

        $docente->user_id = $userDocente->id;
        $docente->numero_identidad = $this->numero_identidad;
        $docente->sexo = $this->sexo;
        $docente->asignatura = $this->asignatura;

        // Convertir cadena vacía a null
        $docente->curso_id = $this->curso_id ?: null;

        $docente->save();

        $this->dispatch('post-created', name: "El docente " . $this->name_docente . ", creado satisfactoriamente");
        $this->clearInput();
        $this->open = false;
    }

    public function cambiar()
    {
        $this->open = true;
    }

    public function render()
    {
        $totalDocente = Docente::all();
        $totalCurso = Curso::all();
        return view('livewire.super-admin.docentes', [
            'totalDocente' => $totalDocente,
            'cursos' => $totalCurso
        ]);
    }
}

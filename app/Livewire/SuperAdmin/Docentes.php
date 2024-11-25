<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Docentes extends Component
{
    #[Validate('required')]
    #[Validate("Unique:docentes,numero_identidad")]

    public $open = false;
    public $openUpdate = false;
    public $name;
    public $numero_identidad;
    public $name_docente;
    public $email;
    public $sexo = '';
    public $asignatura = '';
    public $curso = '';
    public $curso_id = null;
    public $estado;

    public function clearInput()
    {
        $this->name = '';
        $this->email = '';
        $this->numero_identidad = '';
        $this->name_docente = '';
        $this->sexo = '';
        $this->asignatura = '';
        $this->curso = ';¿';
        $this->curso_id = null;
    }

    public function store()
    {
        try {
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

            $docente->curso_id = $this->curso_id ?: null;
            $docente->save();

            $this->dispatch('post-created', name: "El docente " . $this->name_docente . ", creado satisfactoriamente");
            $this->clearInput();
            $this->open = false;
        } catch (\Throwable $th) {
            $this->open = false;
            $this->dispatch('post-error', name: "Error al registrar el docente. Intentelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    public function cambiar()
    {
        $this->clearInput();
        $this->open = true;
    }

    #[On('update-docentes')]
    public function edit($data)
    {
        if ($data) {
            $curso = Curso::where('nombre_curso', $data['curso'])->first();
            if ($curso) {
                $dirCurso = $curso->id;
            } else {
                $dirCurso = '';
            }

            $this->numero_identidad = $data['numero_identidad'];
            $this->name_docente = $data['name'];
            $this->email = $data['email'];
            $this->sexo = $data['sexo'];
            $this->asignatura = $data['asignatura'];
            $this->numero_identidad = $data['numero_identidad'];
            $this->curso_id = $dirCurso;
            $this->estado = $data['estado'];
            $this->openUpdate = true;

        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del docente, intentelo nuevamente");
        }

    }

    public function update()
    {
        try {
            $this->validate(
                [
                    'name_docente' => 'required',
                    'email' => 'required|email',
                    'numero_identidad' => 'required',
                    'sexo' => 'required',
                    'asignatura' => 'required',
                    'estado' => 'required'
                ]
            );

            $docente = Docente::withTrashed()->where('numero_identidad', $this->numero_identidad);
            if (!$docente) {
                $this->openUpdate = false;
                $this->dispatch('post-error', name: "Error no se encontraron registros del docente, intentelo nuevamente");
                $this->clearInput();
            }

            if ($this->estado == 'Eliminado') {
                $docente->delete();
            } else {
                $docente->restore();
            }

            $docente->update([
                'sexo' => $this->sexo,
                'asignatura' => $this->asignatura,
                'curso_id' => $this->curso_id ?: null,
            ]);
            $this->openUpdate = false;
            $this->dispatch('post-created', name: "El docente " . $this->name_docente . ", actualizado satisfactoriamente");
            $this->clearInput();

        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "Error al intentar actualizar los datos del docente. Intentelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    public function render()
    {
        $totalDocenteActivos = Docente::all();
        $totalDocente = Docente::withTrashed()->get();
        $totalCurso = Curso::all();
        return view('livewire.super-admin.docentes', [
            'totalDocenteActivos' => $totalDocenteActivos,
            'totalDocente' => $totalDocente,
            'cursos' => $totalCurso
        ]);
    }
}

<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Docentes extends Component
{
    use WithPagination;

    #[Validate('required')]
    #[Validate("Unique:docentes,numero_identidad")]

    public $open = false;
    public $openFilter = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $name;
    public $numero_identidad;
    public $name_docente;
    public $email;
    public $sexo = '';
    public $asignatura = '';
    public $curso;
    public $curso_id = null;
    public $estado = '';

    public $totalDocenteActivos;
    public $totalDocente;
    public $cursos;

    public $filterDocente = [];


    public function mount()
    {
        $this->totalDocenteActivos = Docente::all();
        $this->totalDocente = Docente::withTrashed()->get();
        $this->cursos = Curso::all();
    }

    public function clearInput()
    {
        $this->name = '';
        $this->email = '';
        $this->numero_identidad = '';
        $this->name_docente = '';
        $this->sexo = '';
        $this->asignatura = '';
        $this->curso = '';
        $this->estado = '';
        $this->curso_id = null;
        $this->mount();
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
            $this->dispatch('post-error', name: "Error al registrar el docente. inténtelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    public function cambiar()
    {
        $this->clearInput();
        $this->open = true;
    }

    public function edit($data)
    {
        if ($data) {
            if ($data['curso']) {
                $curso = Curso::find($data['curso'])->first();
                if ($curso) {
                    $dirCurso = $curso->id;
                }
            } else {
                $dirCurso = '';
            }

            $this->numero_identidad = $data['numero_identidad'];
            $this->name_docente = $data['user']['name'];
            $this->email = $data['user']['email'];
            $this->sexo = $data['sexo'];
            $this->asignatura = $data['asignatura'];
            $this->numero_identidad = $data['numero_identidad'];
            $this->curso_id = $dirCurso;
            $this->estado = $data['deleted_at'] ? 'Eliminado' : 'Activo';
            $this->openUpdate = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del docente, inténtelo nuevamente");
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
                $this->dispatch('post-error', name: "Error no se encontraron registros del docente, inténtelo nuevamente");
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
            $this->dispatch('post-error', name: "Error al intentar actualizar los datos del docente. Inténtelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    public function preDelete($data)
    {
        if ($data) {
            $this->openDelete = true;
            $this->numero_identidad = $data['numero_identidad'];
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del docente, inténtelo nuevamente");
        }
    }

    public function delete()
    {
        try {
            $this->openDelete = false;
            $docente = Docente::where('numero_identidad', $this->numero_identidad)->first();
            if (!$docente) {
                $this->dispatch('post-error', name: "Error: no se encontraron registros del docente, inténtelo nuevamente");
                $this->clearInput();
                return;
            }
            $docente->update([
                'curso_id' => null
            ]);

            $docente->user()->delete();
            $docente->delete();

            $this->dispatch('post-created', name: "El docente ha sido eliminado satisfactoriamente");
            $this->openUpdate = false;
        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "El docente " . $this->name . " no se pudo eliminar. Inténtelo nuevamente");
            throw $th;
        }
    }

    public function filter()
    {
        $this->clearInput();
        $this->openFilter = true;
    }

    public function searchDocente()
    {
        if (!$this->name_docente && !$this->sexo && !$this->estado && !$this->asignatura && !$this->curso) {
            $this->dispatch('post-error', name: "Error: Debe ingresar al menos un campo para realizar la búsqueda");
            return;
        }
        $this->filterDocente = [
            'name_docente' => $this->name_docente,
            'sexo' => $this->sexo,
            'estado' => $this->estado,
            'asignatura' => $this->asignatura,
            'curso' => $this->curso
        ];

        $this->openFilter = false;
    }

    public function render()
    {
        $query = Docente::with('user')->withTrashed();

        if ($this->filterDocente) {
            $query->docente($this->filterDocente);
        }

        return view(
            'livewire.super-admin.docentes',
            [
                'docentes' => $query->paginate(10)
            ]
        );
    }
}

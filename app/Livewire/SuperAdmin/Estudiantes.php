<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Curso;
use App\Models\Estudiante;
use Laravel\Jetstream\Rules\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role as ModelsRole;

class Estudiantes extends Component
{

    use WithPagination;

    #[Validate('required')]
    #[Validate("Unique:estudiantes,numero_identidad")]

    public $open = false;
    public $openUpdate = false;
    public $openFilter = false;
    public $openDelete = false;
    public $openImport = false;

    public $numero_identidad;
    public $nombre_estudiante;
    public $apellido_estudiante;
    public $sexo = '';
    public $curso_id = '';
    public $estado = '';

    public $totalEstudiantesActivos;
    public $totalEstudiantes;
    public $cursos;
    public $filterEstudiante = [];


    public function mount()
    {
        $this->totalEstudiantesActivos = Estudiante::all();
        $this->totalEstudiantes = Estudiante::withTrashed()->get();
        $this->cursos = Curso::all();
    }

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
        try {
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
        } catch (\Throwable $th) {
            $this->open = false;
            $this->dispatch('post-error', name: "Error al registrar el estudiante. inténtelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    public function registrarEstudiante()
    {
        $this->clearInput();
        $this->open = true;
    }

    public function edit($data)
    {
        if ($data) {
            $curso = Curso::find($data['curso'])->first();
            $this->numero_identidad = $data['numero_identidad'];
            $this->nombre_estudiante = $data['nombre_estudiante'];
            $this->apellido_estudiante = $data['apellido_estudiante'];
            $this->sexo = $data['sexo'];
            $this->curso_id = $curso->id;
            $this->estado = $data['deleted_at'] ? 'Eliminado' : 'Activo';
            $this->openUpdate = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del estudiante, inténtelo nuevamente");
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'numero_identidad' => 'required',
                'nombre_estudiante' => 'required',
                'apellido_estudiante' => 'required',
                'sexo' => 'required',
                'curso_id' => 'required',
                'estado' => 'required'
            ]);

            $estudiante = Estudiante::withTrashed()->where('numero_identidad', $this->numero_identidad)->first();

            if (!$estudiante) {
                $this->openUpdate = false;
                $this->dispatch('post-error', name: "Error no se encontraron registros del estudiante, inténtelo nuevamente");
                $this->clearInput();
            }

            if ($this->estado == 'Eliminado') {
                $estudiante->delete();
            } else {
                $estudiante->restore();
            }

            $estudiante->update([
                'nombre_estudiante' => $this->nombre_estudiante,
                'apellido_estudiante' => $this->apellido_estudiante,
                'sexo' => $this->sexo,
                'curso_id' => $this->curso_id,
            ]);


            $this->openUpdate = false;
            $this->dispatch('post-created', name: "El estudiante " . $this->nombre_estudiante . ", actualizado satisfactoriamente");
            $this->clearInput();
        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "Error al intentar actualizar los datos del estudiante. Inténtelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    public function preDelete($data)
    {
        if ($data) {
            $this->numero_identidad = $data['numero_identidad'];
            $this->openDelete = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del estudinate, inténtelo nuevamente");
        }
    }

    public function delete()
    {
        try {
            $this->openDelete = false;
            $estudiante = Estudiante::where('numero_identidad', $this->numero_identidad)->first();
            if (!$estudiante) {
                $this->dispatch('post-error', name: "Error: no se encontraron registros del usuario, inténtelo nuevamente");
                $this->clearInput();
                return;
            }

            $estudiante->delete();

            $this->dispatch('post-created', name: "El estudiante ha sido eliminado satisfactoriamente");
            $this->openDelete = false;
        } catch (\Throwable $th) {
            $this->openDelete = false;
            $this->dispatch('post-error', name: "El estudiante " . $this->name . " no se pudo eliminar. Inténtelo nuevamente");
            throw $th;
        }
    }

    public function filter()
    {
        $this->clearInput();
        $this->openFilter = true;
    }

    public function searchStudents()
    {
        if (!$this->numero_identidad && !$this->nombre_estudiante && !$this->apellido_estudiante && !$this->sexo && !$this->curso_id && !$this->estado) {
            $this->dispatch('post-error', name: "Debe ingresar al menos un campo para realizar la búsqueda");
        }

        $this->filterEstudiante = [
            'numero_identidad' => $this->numero_identidad,
            'nombre_estudiante' => $this->nombre_estudiante,
            'apellido_estudiante' => $this->apellido_estudiante,
            'sexo' => $this->sexo,
            'curso_id' => $this->curso_id
        ];

        $this->openFilter = false;
    }

    public function estudentImport()
    {
        $this->openImport = true;
    }


    public function render()
    {
        $query = Estudiante::withTrashed()->orderBy('curso_id', 'asc');
        if ($this->filterEstudiante) {
            $query->estudiante($this->filterEstudiante);
        }

        return view('livewire.super-admin.estudiantes', [
            'estudiantes' => $query->paginate(50)
        ]);
    }
}

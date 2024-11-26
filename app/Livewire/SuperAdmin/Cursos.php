<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Curso;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Cursos extends Component
{

    #[Validate('required')]

    public $open = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $nombre_curso = '';
    public $curso_id = '';
    public $estado;


    public function clearInput()
    {
        $this->nombre_curso = '';
    }

    public function store()
    {
        try {
            $this->validate([
                'nombre_curso' => 'required'
            ]);

            $cursoExistente = Curso::where('nombre_curso', $this->nombre_curso)->exists();

            if ($cursoExistente) {
                $this->dispatch('post-error', name: "Ya existe un curso con ese nombre");
                return;
            }

            $curso = new Curso();
            $curso->nombre_curso = $this->nombre_curso;
            $curso->save();

            $this->dispatch('post-created', name: "El curso " . $this->nombre_curso . " ha sido creado satisfactoriamente");

            $this->clearInput();
            $this->open = false;
        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "Error al intentar crear el curso. Inténtelo de nuevo");
            throw $th;
        }
    }

    public function cambiar()
    {
        $this->clearInput();
        $this->open = true;
    }

    #[On('update-cursos')] public function edit($data)
    {
        try {
            $this->curso_id = $data['id'];
            if ($data) {
                $this->nombre_curso = $data['nombre_curso'];
                $this->estado = $data['estado'];
                $this->openUpdate = true;

            } else {
                $this->dispatch('post-error', name: "Error no se encontraron registros del curso, inténtelo nuevamente");
            }
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "Error no se encontraron registros del curso, inténtelo nuevamente");
            throw $th;
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'nombre_curso' => 'required',
                'estado' => 'required'

            ]);
            $curso = Curso::withTrashed()->where('id', $this->curso_id)->first();

            if (!$curso) {
                $this->openUpdate = false;
                $this->dispatch('post-error', name: "Error no se encontraron registros del curso, inténtelo nuevamente");
                $this->clearInput();
            }

            if ($this->estado == 'Eliminado') {
                $curso->delete();
            } else {
                $curso->restore();
            }
            $curso->update([
                'nombre_curso' => $this->nombre_curso
            ]);
            $this->dispatch('post-created', name: "El curso " . $this->nombre_curso . ", actualizado satisfactoriamente");
            $this->clearInput();
            $this->openUpdate = false;

        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "Error al intentar actualizar los datos del curso. Inténtelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    #[On('delete-cursos')]
    public function preDelete($data)
    {
        if ($data) {
            $this->openDelete = true;
            $this->curso_id = $data['id'];
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del curso, Inténtelo nuevamente");
        }
    }

    public function delete()
    {
        try {
            $this->openDelete = false;
            $curso = Curso::find($this->curso_id);
            if (!$curso) {
                $this->dispatch('post-error', name: "Error: no se encontraron registros del curso, inténtelo nuevamente");
                $this->clearInput();
                return;
            }

            $curso->estudiantes()->delete();
            $curso->docentes()->delete();
            $curso->delete();

            $this->dispatch('post-created', name: "El curso ha sido eliminado satisfactoriamente");
            $this->openUpdate = false;

        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "El curso " . $this->name . " no se pudo eliminar. Inténtelo nuevamente");
            throw $th;
        }
    }


    public function render()
    {
        $totalCursosActivos = Curso::all();
        $totalCursos = Curso::withTrashed()->get();
        return view(
            'livewire..super-admin.cursos',
            [
                'totalCursos' => $totalCursos,
                'totalCursosActivos' => $totalCursosActivos
            ]
        );
    }
}

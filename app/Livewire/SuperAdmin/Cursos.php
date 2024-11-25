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
            $this->dispatch('post-error', name: "Error al intentar crear el curso. Intentelo de nuevo");
            throw $th;
        }
    }

    public function cambiar()
    {
        $this->clearInput();
        $this->open = true;
    }

    #[On('update-cursos')]
    public function edit($data)
    {
        try {
            $this->curso_id = $data['id'];
            if ($data) {
                $this->nombre_curso = $data['nombre_curso'];
                $this->estado = $data['estado'];
                $this->openUpdate = true;

            } else {
                $this->dispatch('post-error', name: "Error no se encontraron registros del curso, intentelo nuevamente");
            }
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "Error no se encontraron registros del curso, intentelo nuevamente");
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
                $this->dispatch('post-error', name: "Error no se encontraron registros del curso, intentelo nuevamente");
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
            $this->dispatch('post-error', name: "Error al intentar actualizar los datos del curso. Intentelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }


    public function render()
    {
        $totalCursos = Curso::count();
        return view(
            'livewire..super-admin.cursos',
            [
                'totalCursos' => $totalCursos
            ]
        );
    }
}

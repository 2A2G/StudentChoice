<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Curso;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Cursos extends Component
{

    #[Validate('required')]

    public $open = false;

    public $nombre_curso;

    public function clearInput()
    {
        $this->nombre_curso = '';

    }

    public function store()
    {
        $this->validate([
            'nombre_curso' => 'required'
        ]);

        $curso = new Curso();
        $curso->nombre_curso = $this->nombre_curso;
        $curso->save();

        $this->dispatch('post-created', name: "El curso " . $this->nombre_curso . ", creado satisfactoriamente");
        $this->clearInput();
        $this->open = false;
    }

    public function cambiar()
    {
        $this->open = true;
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

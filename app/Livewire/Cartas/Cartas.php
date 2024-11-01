<?php

namespace App\Livewire\Cartas;

use App\Models\Estudiante;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Cartas extends Component
{
    use WithFileUploads;
    public $nombre;
    public $cargo;
    public $curso;
    public $imagen;

    public function mount($nombre, $cargo, $curso, $imagen)
    {
        $this->nombre = $nombre;
        $this->cargo = $cargo;
        $this->curso = $curso;
        $this->imagen = $imagen;
    }

    #[On('estudiante-encontrado')]
    public function estudiante(Estudiante $estudiante){
        $this->nombre = $estudiante->nombre_estudiante;
        $this->cargo = "Representante de curso ";
        $this->curso = $estudiante->curso->nombre_curso;
        // $this->imagen = $estudiante->imagen;
    }

    #[On('upload-image')]
    public function uploadImage($imagen){
        $this->imagen = $imagen;
    }

    public function render()
    {
        return view('livewire.cartas.cartas');
    }
}

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
    //Limpiar los datos de la carta
    #[On('clear-card')]
    public function clearInput()
    {
        $this->nombre = '';
        $this->cargo = '';
        $this->curso = '';
        $this->imagen = '';
    }

    #[On('data-postulante')]
    public function estudiante($dataPostulante)
    {

        $this->nombre = $dataPostulante[0];
        $this->curso = $dataPostulante[1];
        $this->cargo = $dataPostulante[2];
    }


    // #[On('data-postulante-update')]
    // public function estudiante(Postulante $postulante)
    // {
    //     $this->nombre = $postulante->estudiante->nombre_estudiante . ' ' . $postulante->estudiante->apellido_estudiante;
    //     $this->cargo = $postulante->cargo->nombre_cargo;
    //     $this->curso = $postulante->estudiante->curso->nombre_curso;
    //     $this->imagen = Storage::url('imagenes_postulantes/' . $postulante->fotografia_postulante);
    // }

    #[On('upload-image')]
    public function uploadImage($imagen)
    {
        $this->imagen = $imagen;
    }

    public function render()
    {
        return view('livewire.cartas.cartas');
    }
}

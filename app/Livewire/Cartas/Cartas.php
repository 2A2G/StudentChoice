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


    #[On('upload-image')]
    public function uploadImage($imagen, $caso)
    {
        if ($caso == "store") {
            $this->imagen = $imagen;
        } else {
            $this->imagen = $imagen;
        }
    }

    public function render()
    {
        return view('livewire.cartas.cartas');
    }
}

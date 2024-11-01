<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Cargo;
use App\Models\Curso;
use App\Models\Estudiante; // Asegúrate de tener el modelo Estudiante
use App\Models\Postulante;
use Livewire\Component;

use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;


class Postulacion extends Component
{
    use WithFileUploads;

    #[Validate('required')]
    #[Validate("unique:estudiantes,numero_identidad")]

    public $open = false;
    public $numero_identidad;
    public $nombre_postulante;
    public $cargo;
    public $imagen;

    public $curso_postulante;
    public $mensajeError;

    public function clearInput()
    {
        $this->numero_identidad = '';
        $this->cargo = '';
        $this->curso_postulante = '';
        $this->nombre_postulante = '';
        $this->mensajeError = '';
    }

    public function cambiar()
    {
        $this->open = true;
        $this->clearInput();
    }

    public function buscarEstudiante()
    {
        $estudiante = Estudiante::where('numero_identidad', $this->numero_identidad)->first();

        if ($estudiante) {
            $this->nombre_postulante = $estudiante->nombre_estudiante;
            $this->curso_postulante = $estudiante->curso->nombre_curso;
            $this->mensajeError = '';

            if ($estudiante->curso->nombre_curso === 'Decimo') {
                $this->cargo = 'Contralor';
            }
            if ($estudiante->curso->nombre_curso === 'Undecimo') {
                $this->cargo = 'Personero';
            } else {
                $this->cargo = 'Representante de curso';
            }
            if (
                Postulante::where('estudiante_id', $estudiante->id)
                    ->where('anio_postulacion', date('Y'))
                    ->exists()
            ) {
                $this->mensajeError = 'Este estudiante ya se encuentra postulado';
                return;
            }

            $this->dispatch('estudiante-encontrado', $estudiante, $this->imagen);
        } else {
            $this->nombre_postulante = '';
            $this->curso_postulante = '';
            $this->cargo = '';
            $this->mensajeError = 'No existe ningún estudinate con este  número de identidad';
        }
    }


    public function updatedImagen($propertys)
    {
        $this->dispatch('upload-image', $propertys->temporaryUrl());
        // dd($this->imagen);

    }

    public function store()
    {
        $this->validate([
            'numero_identidad' => 'required',
            'imagen' => 'required|image|max:1024',
        ]);

        // Buscar el estudiante por el número de identidad con prefijo
        $newPostulante = Estudiante::where('numero_identidad', $this->numero_identidad)->first();

        // Obtener el cargo según el curso del estudiante
        if ($newPostulante) {
            $cursoPostulante = $newPostulante->curso_id;

            if ($cursoPostulante === 1 || $cursoPostulante < 10) {
                $this->cargo = 'Representante de Curso';
            } elseif ($cursoPostulante === 10) {
                $this->cargo = 'Contralor';
            } else {
                $this->cargo = 'Personero';
            }

            // Almacenar la imagen en la carpeta de almacenamiento
            $fileName = 'P_' . $this->numero_identidad . '.' . $this->imagen->getClientOriginalExtension();
            $this->imagen->storeAs('public/imagenes_postulantes', $fileName);

            // Crear el postulante en la tabla correspondiente
            $nuevoPostulante = new Postulante();
            $nuevoPostulante->estudiante_id = $newPostulante->id;
            $nuevoPostulante->cargo_id = Cargo::where('nombre_cargo', $this->cargo)->first()->id;
            $nuevoPostulante->fotografia_postulante = $fileName;
            $nuevoPostulante->save();

            // Despachar un evento o realizar alguna acción posterior
            $this->dispatch('post-created', name: "La postulación de " . $newPostulante->nombre_estudiante . ", para el cargo de " . $this->cargo . " ha sido creada satisfactoriamente");

            // Limpiar los campos y establecer el estado de apertura a falso
            $this->open = false;
            $this->clearInput();
        } else {
            throw new \Exception('Estudiante no encontrado con el número de identidad proporcionado.');
        }
    }


    public function render()
    {
        $cursos = Curso::all();
        $cargos = Cargo::all();
        $totalPostulantes = Postulante::count();
        return view(
            'livewire.sistema-votacion.postulacion',
            [
                'cursos' => $cursos,
                'cargos' => $cargos,
                'totalPostulantes' => $totalPostulantes
            ]
        );
    }
}

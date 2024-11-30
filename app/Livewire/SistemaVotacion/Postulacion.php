<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Cargo;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Postulante;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;


class Postulacion extends Component
{
    use WithFileUploads;

    #[Validate('required')]
    #[Validate("unique:estudiantes,numero_identidad")]

    public $open = false;
    public $openUpdate = false;
    public $numero_identidad;
    public $nombre_postulante;
    public $cargo;
    public $imagen;
    public $curso_postulante;
    public $postulante_id;
    public $estado;
    public $mensajeError;
    public $type;
    public $data;

    public function clearInput()
    {
        $this->numero_identidad = '';
        $this->cargo = null;
        $this->curso_postulante = '';
        $this->nombre_postulante = '';
        $this->imagen = null;
        $this->mensajeError = '';
    }

    public function cambiar()
    {
        $this->dispatch('clear-card');
        $this->open = true;
        $this->clearInput();
    }

    public function buscarEstudiante()
    {
        $estudiante = Estudiante::where('numero_identidad', $this->numero_identidad)->first();

        if ($estudiante) {
            $this->nombre_postulante = $estudiante->nombre_estudiante . ' ' . $estudiante->apellido_estudiante;
            $this->curso_postulante = $estudiante->curso->nombre_curso;
            $this->mensajeError = '';
            if (
                Postulante::where('estudiante_id', $estudiante->id)
                    ->where('anio_postulacion', date('Y'))
                    ->exists()
            ) {
                $this->mensajeError = 'Este estudiante ya se encuentra postulado';
                return;
            }
            $this->selectionCargo($estudiante);

        } else {
            $this->nombre_postulante = '';
            $this->curso_postulante = '';
            $this->cargo;
            $this->mensajeError = 'No existe ningún estudinate con este  número de identidad';
        }
    }

    public function selectionCargo($data)
    {
        $curso_id = $data['curso_id'];
        $this->data = $data;

        if ($curso_id == Estudiante::decimo) {
            $this->type = true;
            $this->assignDefaultCargo();
        } elseif ($curso_id == Estudiante::undecimo) {
            $this->type = false;
            $this->cargo = 'Personero';
            $this->dispatchDataPostulante();
        } else {
            $this->type = false;
            $this->cargo = 'Representente de curso';
            $this->dispatchDataPostulante();
        }
    }

    public function assignDefaultCargo()
    {
        $this->cargo = $this->cargo ?? '';
        $this->dispatchDataPostulante();
    }

    private function dispatchDataPostulante()
    {
        $dataPostulante = [
            $this->nombre_postulante,
            $this->curso_postulante,
            $this->cargo,

        ];
        $this->dispatch('data-postulante', $dataPostulante);
    }

    public function updatedImagen($property)
    {
        if ($property instanceof TemporaryUploadedFile) {
            $this->dispatch('upload-image', $property->temporaryUrl());
        } else {
            $imageUrl = Storage::url($property);
            $this->dispatch('upload-image', $imageUrl);
        }
    }

    public function store()
    {
        $this->validate([
            'numero_identidad' => 'required',
            'imagen' => 'required|image|max:1024',
        ]);

        $newPostulante = Estudiante::where('numero_identidad', $this->numero_identidad)->first();

        if ($newPostulante) {
            $cursoPostulante = $newPostulante->curso_id;

            if ($cursoPostulante === 1 || $cursoPostulante <= 10) {
                $this->cargo = 'Representante de Curso';
            } elseif ($cursoPostulante === 11) {
                $this->cargo = 'Contralor';
            } else {
                $this->cargo = 'Personero';
            }

            $fileName = 'P_' . $this->numero_identidad . '.' . $this->imagen->getClientOriginalExtension();
            $this->imagen->storeAs('public/imagenes_postulantes', $fileName);

            $nuevoPostulante = new Postulante();
            $nuevoPostulante->estudiante_id = $newPostulante->id;
            $nuevoPostulante->cargo_id = Cargo::where('nombre_cargo', $this->cargo)->first()->id;
            $nuevoPostulante->fotografia_postulante = $fileName;
            $nuevoPostulante->save();

            $this->dispatch('post-created', name: "La postulación de " . $newPostulante->nombre_estudiante . ", para el cargo de " . $this->cargo . " ha sido creada satisfactoriamente");

            $this->open = false;
            $this->clearInput();
        } else {
            throw new \Exception('Estudiante no encontrado con el número de identidad proporcionado.');
        }
    }

    #[On('update-postulantes')]
    public function edit($data)
    {
        $this->clearInput();
        if ($data) {
            $this->postulante_id = $data['id'];
            $postulante = Postulante::where('id', $data['id'])->first();
            $estudiante = Estudiante::where('id', $postulante->estudiante_id)->first();

            $this->nombre_postulante = $postulante->estudiante->nombre_estudiante . ' ' . $postulante->estudiante->apellido_estudiante;
            $this->curso_postulante = $data['cursos'];
            $this->cargo = $data['cargos'];
            $this->imagen = $postulante->fotografia_postulante;
            $this->estado = $data['estado'];

            $imagePath = 'public/imagenes_postulantes/' . $postulante->fotografia_postulante;

            $this->updatedImagen($imagePath);
            $this->selectionCargo($estudiante);
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

            $estudiante = Estudiante::where('numero_identidad', $this->numero_identidad)->first();

            // Verificar si el estudiante existe
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

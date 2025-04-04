<?php

namespace App\Livewire\SistemaVotacion;

use App\Models\Cargo;
use App\Models\Choice;
use App\Models\Comicio;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Postulante;
use App\Models\PostulanteCurso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Postulacion extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Validate('required')]
    #[Validate("unique:estudiantes,numero_identidad")]

    public $open = false;
    public $openFilter = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $numero_identidad;
    public $nombre_postulante;
    public $cargos = '';
    public $cargo = '';
    public $imagen;
    public $curso_postulante = '';
    public $cursos_seleccionados = [];
    public $cursosDisponibles;
    public $postulante_id;
    public $estado = '';
    public $mensajeError;
    public $type;
    public $data;
    public $filePath;
    public $elecciones;
    public $totalPostulantes;
    public $totalPostulantesEliminados;
    public $filterPostulante = [];


    public function clearInput()
    {
        $this->numero_identidad = '';
        $this->cargo = '';
        $this->curso_postulante = '';
        $this->nombre_postulante = '';
        $this->imagen = null;
        $this->filePath = null;
        $this->mensajeError = '';
        $this->cursos_seleccionados = [];
        $this->estado = '';
        $this->filterPostulante = [];
    }

    public function mount()
    {
        $this->totalPostulantes = Postulante::count();
        $this->totalPostulantesEliminados = Postulante::onlyTrashed()->count();
        $this->cargos = Cargo::all();
        $this->cursosDisponibles = Curso::all();
        $this->elecciones = Comicio::where('estado', true)->first();
    }

    public function cambiar()
    {
        if (empty($this->elecciones)) {
            $this->dispatch('post-error', name: 'Lo sentimos, no hay elecciones abiertas en este momento.');
            return;
        }
        if ($this->elecciones->estado_eleccion == true) {
            $this->dispatch('post-warning', name: 'Lo sentimos, hay un comicio en curso, no se pueden realizar postulaciones en este momento.');
            return;
        }


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
                $this->elecciones && Postulante::where('estudiante_id', $estudiante->id)
                ->where('comicio_id', $this->elecciones->id)
                ->exists()
            ) {
                $this->mensajeError = 'Este estudiante ya se encuentra postulado';
                return;
            }
        } else {
            $this->nombre_postulante = '';
            $this->curso_postulante = '';
            $this->cargo = null;
            $this->mensajeError = 'No existe ningún estudinate con este  número de identidad';
        }
    }

    public function dispatchDataPostulante()
    {
        $nombreCargo = Cargo::find($this->cargo);
        $dataPostulante = [
            $this->nombre_postulante,
            $this->curso_postulante,
            $nombreCargo->nombre_cargo,
        ];

        $this->dispatch('data-postulante', $dataPostulante);
    }

    public function updatedImagen($property)
    {
        if ($property instanceof TemporaryUploadedFile) {
            $caso = 'store';
            $this->dispatch('upload-image', $property->temporaryUrl(), $caso);
        } else {
            $imageUrl = Storage::url($property);
            $caso = "update";
            $this->dispatch('upload-image', $imageUrl, $caso);
        }
    }

    public function store()
    {
        $this->validate([
            'numero_identidad' => 'required|exists:estudiantes,numero_identidad',
            'imagen' => 'required|image|max:1024',
            'cursos_seleccionados' => 'required|array|min:1',
            'cargo' => 'required|exists:cargos,id',
            'elecciones' => 'required',
        ]);

        $newPostulante = Estudiante::where('numero_identidad', $this->numero_identidad)->first();

        if ($newPostulante) {
            $fileName = 'P_' . uniqid() . '.' . $this->imagen->getClientOriginalExtension();

            $this->imagen->storeAs('imagenes_postulantes', $fileName, 'public');
            $filePath = $fileName;

            DB::transaction(function () use ($newPostulante, $filePath) {
                $nuevoPostulante = Postulante::create([
                    'estudiante_id' => $newPostulante->id,
                    'cargo_id' => $this->cargo,
                    'curso_id' => $newPostulante->curso_id,
                    'comicio_id' => $this->elecciones->id,
                    'fotografia_postulante' => $filePath,
                ]);

                foreach ($this->cursos_seleccionados as $cursoId) {
                    PostulanteCurso::create([
                        'postulante_id' => $nuevoPostulante->id,
                        'curso_id' => $cursoId
                    ]);
                }
            });

            $nombreCargo = Cargo::find($this->cargo)->first();

            $this->dispatch('post-created', name: "La postulación de {$newPostulante->nombre_estudiante}, para el cargo de " . $nombreCargo->nombre_cargo . ", ha sido creada satisfactoriamente");

            $this->open = false;
            $this->clearInput();
        } else {
            throw new \Exception('Estudiante no encontrado con el número de identidad proporcionado.');
        }
    }

    public function edit($data)
    {
        $this->clearInput();

        if ($data) {
            $this->postulante_id = $data['id'];
            $postulante = Postulante::withTrashed()->find($data['id']);

            if ($postulante) {
                $cursoPostulante = Curso::find($postulante->curso_id);
                $cargoPostulante = Cargo::find($postulante->cargo_id);

                $this->nombre_postulante = $postulante->estudiante->nombre_estudiante . ' ' . $postulante->estudiante->apellido_estudiante;
                $this->curso_postulante = $cursoPostulante->nombre_curso;
                $this->cargo = $cargoPostulante->id;
                $this->updatedImagen($postulante->fotografia_postulante);

                $cursoPostulante = PostulanteCurso::where('postulante_id', $postulante->id)->get();
                $this->cursos_seleccionados = $cursoPostulante->pluck('curso_id')->toArray();

                $this->estado = $data['deleted_at'] ? 'Eliminado' : 'Activo';

                $this->dispatchDataPostulante();
                $this->openUpdate = true;
            } else {
                $this->dispatch('post-error', name: "No se encontró información del postulante, inténtelo nuevamente.");
            }
        } else {
            $this->dispatch('post-error', name: "Error al cargar datos, por favor intente nuevamente.");
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'nombre_postulante' => 'required',
                'cargo' => 'required',
                'cursos_seleccionados' => 'required|array|min:1',
            ]);
            $postulante = Postulante::withTrashed()->find($this->postulante_id);
            if (!$postulante) {
                $this->dispatch('post-error', name: "No se encontró información del postulante, inténtelo nuevamente.");
                $this->clearInput();
                return;
            }

            if ($this->estado == 'Eliminado') {
                $postulante->delete();
            } else {
                $postulante->restore();
            }

            $postulante->update([
                'cargo_id' => $this->cargo,
            ]);
            PostulanteCurso::where('postulante_id', $postulante->id)->delete();

            foreach ($this->cursos_seleccionados as $cursoId) {
                PostulanteCurso::create([
                    'postulante_id' => $postulante->id,
                    'curso_id' => $cursoId,
                ]);
            }

            $this->dispatch('post-created', name: "El postulante {$this->nombre_postulante} se actualizó satisfactoriamente.");
            $this->openUpdate = false;
            $this->clearInput();
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "Error al intentar actualizar los datos del postulante. Inténtelo nuevamente.");
            $this->openUpdate = false;
            $this->clearInput();
            throw $th;
        }
    }

    public function preDelete($data)
    {
        // dd($data);
        if ($data) {
            $this->openDelete = true;
            $this->postulante_id = $data['id'];
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del estudinate, inténtelo nuevamente");
        }
    }

    public function delete()
    {
        try {
            $this->openDelete = false;
            $postulante = Postulante::find($this->postulante_id);
            if (!$postulante) {
                $this->dispatch('post-error', name: "Error: no se encontraron registros del postulante, inténtelo nuevamente");
                $this->clearInput();
                return;
            }

            $postulante->delete();
            $this->dispatch('post-created', name: "El postulante ha sido eliminado satisfactoriamente");
            $this->openUpdate = false;
        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "No se pudo eliminar el regitro del postulante. Inténtelo nuevamente");
            throw $th;
        }
    }

    public function filter()
    {
        $this->clearInput();
        $this->openFilter = true;
    }

    public function searchPostulante()
    {
        if (!$this->numero_identidad && !$this->curso_postulante && !$this->cargo && !$this->elecciones && !$this->estado) {
            $this->dispatch('post-error', name: "Por favor, ingrese al menos un campo para realizar la búsqueda.");
            return;
        }

        $this->filterPostulante = [
            'numero_identidad' => $this->numero_identidad,
            'curso_postulante' => $this->curso_postulante,
            'cargo' => $this->cargo,
            'eleccion' => $this->eleccion->id,
            'estado' => $this->estado,
        ];
        $this->openFilter = false;
    }

    public function render()
    {
        $query = Postulante::with('estudiante', 'cargo', 'curso', 'comicio')->withTrashed();

        if ($this->filterPostulante) {
            $query->postulante($this->filterPostulante);
        }

        return view(
            'livewire.sistema-votacion.postulacion',
            [
                'postulantes' => $query->paginate(10)
            ]
        );
    }
}

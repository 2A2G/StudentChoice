<?php

namespace App\Livewire\Diagramas;

use App\Livewire\SuperAdmin\Cursos;
use App\Models\Cargo;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Postulante;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Table extends Component
{

    use WithPagination;

    public $columns = [];
    public $data, $dataI;

    public $roles;
    public $case;
    public $open;
    public $type;
    public $inDelete;
    public $inUpdate;


    public function datos()
    {
        switch ($this->case) {
            case 'roles':
                $rolesPaginated = Role::getRoleData(10);
                $this->data = $rolesPaginated->items();
                $this->dataI = ['name', 'estado'];
                $this->columns = ['Nombre del Rol', 'estado'];
                break;

            case 'permisos':
                $permissionsPaginated = Permission::getPaginatedPermissions(10);

                $this->data = $permissionsPaginated->items();
                $this->dataI = ['name', 'estado'];
                $this->columns = ['Nombre del Permiso', 'estado', 'Acción'];
                break;

            case 'usuarios':
                $usuariosPaginate = User::getUserData(10);

                $this->data = $usuariosPaginate->items();
                $this->dataI = ['name', 'email', 'role', 'estado'];
                $this->columns = ['Nombre del Usuario', 'Correo Electrónico', 'Rol', 'Estado', 'Acción'];
                break;

            case 'cursos':
                $cursosPaginate = Curso::getCursoData(10);

                $this->data = $cursosPaginate->items();
                $this->dataI = ['nombre_curso', 'cantidad_estudiantes_masculinos', 'cantidad_estudiantes_femeninos', 'cantidad_estudiantes', 'estado'];
                $this->columns = ['Nombre del Curso', 'Cantidad de Estudiantes Masculinos', 'Cantidad de Estudiantes Femeninos', 'Total de Estudiantes', 'Estado', 'Acción'];
                break;

            case 'estudiantes':
                $estudiantesPaginate = Estudiante::getEstudianteData(10);

                $this->data = $estudiantesPaginate->items();
                $this->dataI = ['numero_identidad', 'nombre_estudiante', 'apellido_estudiante', 'sexo', 'curso', 'estado'];
                $this->columns = ['Número de Identidad', 'Nombre', 'Apellido', 'Sexo', 'Curso', 'Estado', 'Acción'];
                break;

            case 'docentes':
                $docentesPaginate = Docente::getDocenteData(10);

                $this->data = $docentesPaginate->items();
                $this->dataI = ['numero_identidad', 'name', 'asignatura', 'sexo', 'curso', 'estado'];
                $this->columns = ['Número de Identidad', 'Docente', 'Nombre de la asignatura', 'Sexo', 'Director del Curso', 'estado', 'Acción'];
                break;

            case 'postulantes':
                $postulantesPaginate = Postulante::getPostulanteData(10);

                $this->data = $postulantesPaginate->items();
                $this->dataI = ['estudiante', 'cursos', 'cargos', 'estado'];
                $this->columns = ['estudiante', 'curso', 'cargo', 'estado', 'accion'];
                break;

            case 'cargos':
                $cargosPaginate = Cargo::getCargoData(10);

                $this->data = $cargosPaginate->items();
                $this->dataI = ['nombre_cargo', 'descripcion_cargo', 'estado'];
                $this->columns = ['Nombre del cargo', 'Descripcion del cargo', 'estado', 'accion'];
                break;

            case 'anio_postulacion':
                $postulacionAnios = Postulante::getAnioData(10);
                $this->data = $postulacionAnios->items();
                $this->dataI = ['anio_postulacion', 'cantidad_postulantes'];
                $this->columns = ['Año de postulación', 'Cantidad de postulantes', 'Acción'];
                break;

            default:
                $defaultPaginated = Role::simplePaginate(10, ['id', 'name']);
                $this->data = $defaultPaginated->items();
                $this->dataI = ['name'];
                $this->columns = ['Nombre del Rol', 'Acción'];
                break;
        }

        // Devolver la colección paginada completa para la vista
        return $rolesPaginated ?? $permissionsPaginated ?? $usuariosPaginate ?? $defaultPaginated ?? $estudiantesPaginate
            ?? $docentesPaginate ?? $cargosPaginate ?? $postulantesPaginate ?? $postulacionAnios ?? $cursosPaginate
            ?? null;
    }

    protected array $modelsMap = [
        'roles' => Role::class,
        'permisos' => Permission::class,
        'usuarios' => User::class,
        'cursos' => Curso::class,
        'estudiantes' => Estudiante::class,
        'docentes' => Docente::class,
        'postulantes' => Postulante::class,
        'cargos' => Cargo::class,
        'anio_postulacion' => 'año_postulacion',
    ];

    public function openModal($dato, $row): void
    {
        $this->type = $dato === 'editar' ? 'Editar' : 'Eliminar';

        if ($this->type === 'Editar') {
            $this->inUpdate = [$this->modelsMap[$this->case] ?? '', $row];
            $nameDispacth = "update-" . $this->case;
            $data = $this->inUpdate[1];
            $this->dispatch($nameDispacth, $data);
        } else {
            $this->inDelete = [$this->modelsMap[$this->case] ?? '', $row];
            $nameDispacth = "delete-" . $this->case;
            $data = $this->inDelete[1];
            $this->dispatch($nameDispacth, $data);
        }
    }

    public function mount($columns = [], $data = [])
    {
        $this->datos();
    }

    #[On('post-created')]
    public function refresh()
    {
        $this->datos();
    }

    public function render()
    {
        $paginatedData = $this->datos();
        return view('livewire.diagramas.table', [
            'data' => $this->data,
            'pagination' => $paginatedData,
            'case' => $this->case,
        ]);
    }
}

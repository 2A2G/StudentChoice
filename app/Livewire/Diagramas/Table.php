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
                $rolesPaginated = Role::select(
                    'id',
                    'name',
                    DB::raw('CASE WHEN deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
                )
                    ->simplePaginate(10, [
                        'id',
                        'name',
                        'estado'
                    ]);
                $this->data = $rolesPaginated->items();
                $this->dataI = ['name', 'estado'];
                $this->columns = ['Nombre del Rol', 'estado'];
                break;


            case 'permisos':
                $permissionsPaginated = Permission::select(
                    'id',
                    'name',
                    DB::raw('CASE WHEN deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')

                )->simplePaginate(10, [
                            'id',
                            'name',
                            'estado'
                        ]);


                $this->data = $permissionsPaginated->items();
                $this->dataI = ['name', 'estado'];
                $this->columns = ['Nombre del Permiso', 'estado', 'Acción'];
                break;


            case 'usuarios':
                $usuariosPaginate = User::withTrashed()
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->select(
                        'users.id',
                        'users.name',
                        'users.email',
                        DB::raw('COALESCE(roles.name, \'No\') AS role'),
                        DB::raw('CASE WHEN users.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
                    )
                    ->orderByRaw('users.id')
                    ->simplePaginate(10);

                $this->data = $usuariosPaginate->items();
                $this->dataI = ['name', 'email', 'role', 'estado'];
                $this->columns = ['Nombre del Usuario', 'Correo Electrónico', 'Rol', 'estado', 'Acción'];
                break;

            case 'cursos':
                $cursosPaginate = Curso::withTrashed()
                    ->leftJoin('estudiantes', 'cursos.id', '=', 'estudiantes.curso_id')
                    ->select(
                        'cursos.id',
                        'cursos.nombre_curso',
                        DB::raw('SUM(CASE WHEN estudiantes.sexo = \'Masculino\' THEN 1 ELSE 0 END) as cantidad_estudiantes_masculinos'),
                        DB::raw('SUM(CASE WHEN estudiantes.sexo = \'Femenino\' THEN 1 ELSE 0 END) as cantidad_estudiantes_femeninos'),
                        DB::raw('COUNT(estudiantes.id) as cantidad_estudiantes'),
                        DB::raw('CASE WHEN cursos.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
                    )
                    ->groupBy('cursos.id', 'cursos.nombre_curso', 'cursos.deleted_at')
                    ->orderByRaw('cursos.id')
                    ->simplePaginate(10);

                $this->data = $cursosPaginate->items();
                $this->dataI = ['nombre_curso', 'cantidad_estudiantes_masculinos', 'cantidad_estudiantes_femeninos', 'cantidad_estudiantes', 'estado'];
                $this->columns = ['Nombre del Curso', 'Cantidad de Estudiantes Masculinos', 'Cantidad de Estudiantes Femeninos', 'Total de Estudiantes', 'Estado', 'Acción'];
                break;



            case 'estudiantes':
                $estudiantesPaginate = Estudiante::withTrashed()
                    ->join('cursos', 'estudiantes.curso_id', '=', 'cursos.id')
                    ->select(
                        'estudiantes.id',
                        'estudiantes.numero_identidad',
                        'estudiantes.nombre_estudiante',
                        'estudiantes.apellido_estudiante',
                        'estudiantes.sexo',
                        'cursos.nombre_curso as curso',
                        DB::raw('CASE WHEN estudiantes.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
                    )
                    ->orderByRaw('cursos.id')
                    ->simplePaginate(10);

                $this->data = $estudiantesPaginate->items();
                $this->dataI = ['numero_identidad', 'nombre_estudiante', 'apellido_estudiante', 'sexo', 'curso', 'estado'];
                $this->columns = ['Número de Identidad', 'Nombre', 'Apellido', 'Sexo', 'Curso', 'Estado', 'Acción'];
                break;


            case 'docentes':
                $docentesPaginate = Docente::withTrashed()
                    ->leftJoin('cursos', 'docentes.curso_id', '=', 'cursos.id')
                    ->leftJoin('users', 'docentes.user_id', '=', 'users.id')
                    ->select(
                        'docentes.id',
                        'users.name',
                        'users.email',
                        'docentes.numero_identidad',
                        'docentes.asignatura',
                        'docentes.sexo',
                        DB::raw('COALESCE(cursos.nombre_curso, \'No\') AS curso'),
                        DB::raw('CASE WHEN docentes.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
                    )
                    ->orderByRaw('docentes.id')
                    ->simplePaginate(10);

                $this->data = $docentesPaginate->items();
                $this->dataI = ['numero_identidad', 'name', 'asignatura', 'sexo', 'curso', 'estado'];
                $this->columns = ['Número de Identidad', 'Docente', 'Nombre de la asignatura', 'Sexo', 'Director del Curso', 'estado', 'Acción'];
                break;


            case 'postulantes':
                $postulantesPaginate = Postulante::withTrashed()
                    ->join('estudiantes', 'postulantes.estudiante_id', '=', 'estudiantes.id')
                    ->join('cargos', 'postulantes.cargo_id', '=', 'cargos.id')
                    ->join('cursos', 'estudiantes.curso_id', '=', 'cursos.id')

                    ->select(
                        'postulantes.id',
                        'estudiantes.nombre_estudiante as estudiantes',
                        'cursos.nombre_curso as cursos',
                        'cargos.nombre_cargo as cargos',
                        DB::raw('CASE WHEN postulantes.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')

                    )
                    ->simplePaginate(10);

                $this->data = $postulantesPaginate->items();
                $this->dataI = ['estudiantes', 'cursos', 'cargos', 'estado'];
                $this->columns = ['estudiante', 'curso', 'cargo', 'estado', 'accion'];
                break;


            case 'cargos':
                $cargosPaginate = Cargo::withTrashed()->select(
                    'id',
                    'nombre_cargo',
                    'descripcion_cargo',
                    DB::raw('CASE WHEN deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
                )->simplePaginate(10);

                $this->data = $cargosPaginate->items();
                $this->dataI = ['nombre_cargo', 'descripcion_cargo', 'estado'];
                $this->columns = ['Nombre del cargo', 'Descripcion del cargo', 'estado', 'accion'];
                break;


            case 'anio_postulacion':
                // Agrupar por año de postulación y mostrar el año y la cantidad de postulantes totales para ese año
                $postulacionAnios = Postulante::withTrashed()->select('anio_postulacion', DB::raw('count(*) as cantidad_postulantes'))
                    ->groupBy('anio_postulacion')
                    ->simplePaginate(10);

                // Ajustar los datos para la vista
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
            'pagination' => $paginatedData, // Pasa la colección paginada completa
            'case' => $this->case,
        ]);
    }
}

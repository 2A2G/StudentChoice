<?php

namespace App\Livewire\Diagramas;

use App\Livewire\SuperAdmin\Cursos;
use App\Models\Cargo;
use App\Models\Comicio;
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
        $cases = [
            'roles' => [
                'model' => Role::class,
                'method' => 'getRoleData',
                'dataI' => ['name', 'estado'],
                'columns' => ['Nombre del Rol', 'Estado']
            ],
            'permisos' => [
                'model' => Permission::class,
                'method' => 'getPermissionData',
                'dataI' => ['name', 'estado'],
                'columns' => ['Nombre del Permiso', 'Estado', 'Acción']
            ],
            'usuarios' => [
                'model' => User::class,
                'method' => 'getUserData',
                'dataI' => ['name', 'email', 'role', 'estado'],
                'columns' => ['Nombre del Usuario', 'Correo Electrónico', 'Rol', 'Estado', 'Acción']
            ],
            'cursos' => [
                'model' => Curso::class,
                'method' => 'getCursoData',
                'dataI' => ['nombre_curso', 'cantidad_estudiantes_masculinos', 'cantidad_estudiantes_femeninos', 'cantidad_estudiantes', 'estado'],
                'columns' => ['Nombre del Curso', 'Cantidad de Estudiantes Masculinos', 'Cantidad de Estudiantes Femeninos', 'Total de Estudiantes', 'Estado', 'Acción']
            ],
            'estudiantes' => [
                'model' => Estudiante::class,
                'method' => 'getEstudianteData',
                'dataI' => ['numero_identidad', 'nombre_estudiante', 'apellido_estudiante', 'sexo', 'curso', 'estado'],
                'columns' => ['Número de Identidad', 'Nombre', 'Apellido', 'Sexo', 'Curso', 'Estado', 'Acción']
            ],
            'docentes' => [
                'model' => Docente::class,
                'method' => 'getDocenteData',
                'dataI' => ['numero_identidad', 'name', 'asignatura', 'sexo', 'curso', 'estado'],
                'columns' => ['Número de Identidad', 'Docente', 'Nombre de la Asignatura', 'Sexo', 'Director del Curso', 'Estado', 'Acción']
            ],
            'postulantes' => [
                'model' => Postulante::class,
                'method' => 'getPostulanteData',
                'dataI' => ['estudiante', 'cursos', 'cargos', 'estado'],
                'columns' => ['Estudiante', 'Curso', 'Cargo', 'Estado', 'Acción']
            ],
            'cargos' => [
                'model' => Cargo::class,
                'method' => 'getCargoData',
                'dataI' => ['nombre_cargo', 'descripcion_cargo', 'estado'],
                'columns' => ['Nombre del Cargo', 'Descripción del Cargo', 'Estado', 'Acción']
            ],
            'comicio' => [
                'model' => Comicio::class,
                'method' => 'getComicio',
                'dataI' => ['nombre_eleccion', 'cantidad_postulantes'],
                'columns' => ['Año de Postulación', 'Cantidad de Postulantes', 'Acción']
            ],
            'default' => [
                'model' => Role::class,
                'method' => 'simplePaginate',
                'params' => [10, ['id', 'name']],
                'dataI' => ['name'],
                'columns' => ['Nombre del Rol', 'Acción']
            ]
        ];

        $caseConfig = $cases[$this->case] ?? $cases['default'];

        $paginateMethod = $caseConfig['method'];
        $params = $caseConfig['params'] ?? [10];
        $paginatedData = $caseConfig['model']::$paginateMethod(...$params);

        $this->data = $paginatedData->items();
        $this->dataI = $caseConfig['dataI'];
        $this->columns = $caseConfig['columns'];

        return $paginatedData;
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

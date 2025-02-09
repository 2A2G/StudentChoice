<?php

namespace App\Livewire\SuperAdmin;

use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;

    public $open = false;
    public $openFilterRol = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $name_rol;
    public $id_rol;
    public $permiso_seleccionado = [];
    public $estado = '';

    public $openUpdatePermisos = false;
    public $openDeletePermisos = false;
    public $name_permiso;
    public $id_permiso;
    public $filterRole = [];

    public $totalRolesActivos;
    public $totalRoles;

    public $totalPermisosActivos;
    public $totalPermisos;

    #[Validate('required')]
    #[Validate("Unique:roles,name")]

    public function mount()
    {
        $this->totalRolesActivos = Role::whereNull('deleted_at')->count();
        $this->totalPermisosActivos = Permission::whereNull('deleted_at')->count();
        $this->totalRoles = Role::withTrashed()->count();
        $this->totalPermisos = Permission::withTrashed()->count();
    }


    private function clearInput()
    {
        $this->name_rol = '';
        $this->id_rol = '';
        $this->permiso_seleccionado = [];
        $this->estado = '';
        $this->mount();
    }

    public function openCreateRol()
    {
        $this->clearInput();
        $this->open = true;
    }

    public function store()
    {
        try {
            $this->validate(
                [
                    'name_rol' => 'required',
                    'permiso_seleccionado' => 'required|array|min:1',
                ]
            );

            DB::transaction(function () {
                $nuevoRol = Role::create([
                    'name' => $this->name_rol,
                ]);

                $nuevoRol->permissions()->sync($this->permiso_seleccionado);
            });

            $this->dispatch('post-created', name: "Se ha creado satisfactoriamente el rol, " . $this->name_rol);
            $this->open = false;
            $this->clearInput();
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "Error al registrar el rol. inténtelo de nuevo");
            $this->clearInput();
            throw $th;
        }
    }

    public function edit($data)
    {
        if ($data) {
            $this->name_rol = $data['name'];
            $this->id_rol = $data['id'];
            $this->estado = $data['deleted_at'] ? 'Eliminado' : 'Activo';

            $rol = Role::withTrashed()->find($this->id_rol);
            $this->permiso_seleccionado = $rol->permissions->pluck('id')->toArray();
            $this->openUpdate = true;
        } else {
            $this->dispatch('post-error', name: "Error, no se encontraron registros del rol. Inténtelo nuevamente.");
            $this->clearInput();
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'name_rol' => 'required',
                'permiso_seleccionado' => 'required|array|min:1',
            ]);

            $roleUpdate = Role::withTrashed()->find($this->id_rol);

            if (!$roleUpdate) {
                $this->dispatch('post-error', name: "El rol no existe.");
                return;
            }
            if ($this->estado == 'Eliminado') {
                $roleUpdate->delete();
            } else {
                $roleUpdate->restore();
            }

            $roleUpdate->update([
                'name' => $this->name_rol,
            ]);

            $roleUpdate->permissions()->sync($this->permiso_seleccionado);

            $this->dispatch('post-created', name: "Se ha actualizado satisfactoriamente el rol, " . $this->name_rol);
            $this->openUpdate = false;
            $this->clearInput();
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "Error al registrar el rol. Inténtelo de nuevo");
            $this->clearInput();
            $this->openUpdate = false;
            throw $th;
        }
    }

    public function preDelete($data)
    {
        if ($data) {
            $this->name_rol = $data['name'];
            $this->id_rol = $data['id'];
            $this->openDelete = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del rol, inténtelo nuevamente");
            $this->clearInput();
        }
    }

    public function delete()
    {
        try {
            $this->openDelete = false;
            $roleDelete = Role::find($this->id_rol);
            if (!$roleDelete) {
                $this->dispatch('post-error', name: "Error: no se encontraron registros del rol, inténtelo nuevamente");
                $this->clearInput();
                return;
            }

            $roleDelete->delete();

            $this->dispatch('post-created', name: "El rol ha sido eliminado satisfactoriamente");
            $this->clearInput();
        } catch (\Throwable $th) {
            $this->openDelete = false;
            $this->dispatch('post-error', name: "El rol " . $this->name_rol . " no se pudo eliminar. Inténtelo nuevamente");
            $this->clearInput();
            throw $th;
        }
    }

    public function openFilterRole()
    {
        $this->openFilterRol = true;
    }

    public function searchRole()
    {
        if (!$this->name_rol && !$this->estado) {
            $this->dispatch('post-error', name: "Debe ingresar al menos un campo para realizar la búsqueda");
        }

        $this->filterRole = [
            'name_rol' => $this->name_rol,
            'estado' => $this->estado,
        ];
        $this->openFilterRol = false;
    }


    // Permisos
    public function editPermisos($data)
    {
        if ($data) {
            $this->name_permiso = $data['name'];
            $this->id_permiso = $data['id'];
            $this->estado = $data['deleted_at'] ? 'Eliminado' : 'Activo';
            $this->openUpdatePermisos = true;
        } else {
            $this->dispatch('post-error', name: "Error, no se encontraron registros del rol. Inténtelo nuevamente.");
            $this->clearInput();
        }
    }

    public function updatePermiso()
    {
        try {
            $this->validate([
                'estado' => 'required',
            ]);

            $permisoUpdate = Permission::withTrashed()->find($this->id_permiso);

            if (!$permisoUpdate) {
                $this->dispatch('post-error', name: "El permiso no existe.");
                return;
            }
            if ($this->estado == 'Eliminado') {
                $permisoUpdate->delete();
            } else {
                $permisoUpdate->restore();
            }

            $this->dispatch('post-created', name: "Se ha actualizado satisfactoriamente el permiso, " . $this->name_permiso);
            $this->openUpdatePermisos = false;
            $this->clearInput();
        } catch (\Throwable $th) {
            $this->dispatch('post-error', name: "Error al registrar el permiso. Inténtelo de nuevo");
            $this->clearInput();
            $this->openUpdatePermisos = false;
            throw $th;
        }
    }

    public function preeDeletePermisos($data)
    {
        if ($data) {
            $this->name_permiso = $data['name'];
            $this->id_permiso = $data['id'];
            $this->openDeletePermisos = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del permiso, inténtelo nuevamente");
            $this->clearInput();
        }
    }

    public function deletePermisos()
    {
        try {
            $this->openDeletePermisos = false;
            $permisoDelete = Permission::find($this->id_permiso);
            if (!$permisoDelete) {
                $this->dispatch('post-error', name: "Error: no se encontraron registros del permiso, inténtelo nuevamente");
                $this->clearInput();
                return;
            }

            $permisoDelete->delete();

            $this->dispatch('post-created', name: "El permiso ha sido eliminado satisfactoriamente");
            $this->clearInput();
        } catch (\Throwable $th) {
            $this->openDeletePermisos = false;
            $this->dispatch('post-error', name: "El permiso " . $this->name_permiso . " no se pudo eliminar. Inténtelo nuevamente");
            $this->clearInput();
            throw $th;
        }
    }

    public function render()
    {
        $query = Role::withTrashed();
        if ($this->filterRole) {
            $query->Role($this->filterRole);
        }

        $permuiso = Permission::withTrashed();

        $roles = $query->paginate(10, ['*'], 'page_roles');

        $permisos = $permuiso->paginate(20, ['*'], 'page_permisos');
        return view('livewire.super-admin.roles', [
            'roles' => $roles,
            'permisosDisponibles' => Permission::all(),
            'permisos' => $permisos,
        ]);
    }
}

<?php

namespace App\Livewire\SuperAdmin;

use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public $open = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $name_rol;
    public $id_rol;
    public $permisosDisponibles;
    public $permiso_seleccionado = [];
    public $estado = '';

    public $openUpdatePermisos = false;
    public $openDeletePermisos = false;
    public $name_permiso;
    public $id_permiso;


    #[Validate('required')]
    #[Validate("Unique:roles,name")]

    private function clearInput()
    {
        $this->name_rol = '';
        $this->id_rol = '';
        $this->permisosDisponibles = '';
        $this->permiso_seleccionado = [];
        $this->estado = '';
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

    #[On('update-roles')]
    public function edit($data)
    {
        if ($data) {
            $this->name_rol = $data['name'];
            $this->id_rol = $data['id'];
            $this->estado = $data['estado'];

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

    #[On('delete-roles')]
    public function preeDelete($data)
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


    // Permisos
    #[On('update-permisos')]
    public function editPermisos($data)
    {
        if ($data) {
            $this->name_permiso = $data['name'];
            $this->id_permiso = $data['id'];
            $this->estado = $data['estado'];
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

    #[On('delete-permisos')]
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
        $this->permisosDisponibles = Permission::all();
        $totalRoles = Role::count();
        $totalPermisos = Permission::count();
        return view('livewire.super-admin.roles', [
            'totalRoles' => $totalRoles,
            'totalPermisos' => $totalPermisos
        ]);
    }
}

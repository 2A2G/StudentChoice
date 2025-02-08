<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Usuarios extends Component
{
    use WithPagination;

    public $open = false;
    public $openFilter = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $name;
    public $estado = '';
    public $role = '';
    public $email;
    public $roles;
    public $permisos;
    public $filterUser;

    public function clearInput()
    {
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->estado = '';
        $this->mount();
    }
    public function mount()
    {
        $this->roles = Role::all(['id', 'name'])->toArray();
        $this->permisos = Permission::get()->toArray();
    }


    public function cambiar()
    {
        $this->clearInput();
        $this->open = true;
    }

    public function store()
    {
        try {
            $this->validate(
                [
                    'name' => 'required',
                    'email' => 'required|email',
                    'role' => 'required'
                ]
            );

            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = bcrypt('password');
            $user->save();

            $user->syncRoles([$this->role]);

            $this->dispatch('post-created', name: "El usuario " . $this->name . ", creado satisfactoriamente");
            $this->clearInput();
            $this->open = false;
        } catch (\Throwable $th) {
            $this->open = false;
            $this->dispatch('post-error', name: "Error al crear el usuario. Intentelo de nuevo");
            throw $th;
        }
    }

    public function edit($data)
    {
        if ($data) {
            $this->name = $data['name'];
            $this->email = $data['email'];

            if (isset($data['roles'][0])) {
                $this->role = $data['roles'][0]['name'];
            } else {
                $this->role = '';
            }

            if (isset($data['estado'])) {
                $this->estado = $data['estado'];
            } else {
                $this->estado = 'Activo';
            }

            $this->openUpdate = true;
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del usuario, intentelo nuevamente");
        }
    }

    public function update()
    {
        try {
            $this->validate(
                [
                    'name' => 'required',
                    'email' => 'required|email',
                    'role' => 'required',
                    'estado' => 'required'
                ]
            );

            $user = User::withTrashed()->where('email', $this->email)->first();

            if (!$user) {
                $this->openUpdate = false;
                $this->dispatch('post-error', name: "Error: no se encontraron registros del usuario, intentelo nuevamente");
                $this->clearInput();
                return;
            }

            if ($this->estado == "Eliminado") {
                $user->delete();
            } else {
                $user->restore();
            }

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            $user->syncRoles([$this->role]);

            $this->dispatch('post-created', name: "El usuario " . $this->name . " ha sido actualizado satisfactoriamente");
            $this->clearInput();
            $this->openUpdate = false;
        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "El usuario " . $this->name . " no se pudo actualizar. Intentelo nuevamente");
            throw $th;
        }
    }

    public function preDelete($data)
    {
        if ($data) {
            $this->openDelete = true;
            $this->email = $data['email'];
        } else {
            $this->dispatch('post-error', name: "Error no se encontraron registros del usuario, intentelo nuevamente");
        }
    }

    public function delete()
    {
        try {
            $this->openDelete = false;
            $user = User::where('email', $this->email)->first();
            if (!$user) {
                $this->dispatch('post-error', name: "Error: no se encontraron registros del usuario, intentelo nuevamente");
                $this->clearInput();
                return;
            }

            $user->delete();

            $this->dispatch('post-created', name: "El usuario ha sido eliminado satisfactoriamente");
            $this->openUpdate = false;
            $this->clearInput();
        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "El usuario " . $this->name . " no se pudo eliminar. Intentelo nuevamente");
            throw $th;
        }
    }

    public function filter()
    {
        $this->openFilter = true;
    }

    public function searchUser()
    {
        if (!$this->name && !$this->email && !$this->role && !$this->estado) {
            $this->dispatch('post-warning', name: "Debe ingresar al menos un campo para filtrar");
        }

        $this->filterUser = [
            'name'   => $this->name,
            'email'  => $this->email,
            'role'   => $this->role,
            'estado' => $this->estado,
        ];

        $this->openFilter = false;
    }

    public function render()
    {
        $query = User::withTrashed();

        if ($this->filterUser) {
            $query->filter($this->filterUser);
        }

        return view('livewire.super-admin.usuarios', [
            'user' => $query->paginate(10),
        ]);
    }
}

<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Usuarios extends Component
{

    #[Validate('required')]
    #[Validate("Unique:users,name, users,email")]

    public $open = false;
    public $openFilter = false;
    public $openUpdate = false;
    public $openDelete = false;
    public $name;
    public $estado = '';
    public $role = '';
    public $email;


    public function clearInput()
    {
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->estado = '';
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
            $this->open = false;
        } catch (\Throwable $th) {
            $this->open = false;
            $this->dispatch('post-error', name: "Error al crear el usuario. Intentelo de nuevo");
            throw $th;
        }
    }

    #[On('update-usuarios')]
    public function edit($data)
    {
        if ($data) {
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->role = $data['role'];
            $this->estado = $data['estado'];
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
            $this->openUpdate = false;
        } catch (\Throwable $th) {
            $this->openUpdate = false;
            $this->dispatch('post-error', name: "El usuario " . $this->name . " no se pudo actualizar. Intentelo nuevamente");
            throw $th;
        }
    }

    #[On('delete-usuarios')]
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
            session()->flash('error', 'Debe ingresar al menos un dato para filtrar.');
            return;
        }

        $searchResults = [
            'name'   => $this->name,
            'email'  => $this->email,
            'role'   => $this->role,
            'estado' => $this->estado,
        ];

        $this->dispatch('search-users', $searchResults);
        $this->openFilter = false;
    }



    public function render()
    {
        $userActivos = User::all();
        $user = User::withTrashed()->get();
        $rol = Role::all('id', 'name');
        $permisos = Permission::get();
        return view(
            'livewire.super-admin.usuarios',
            [
                'userActivos' => $userActivos,
                'user' => $user,
                'roles' => $rol,
                'permisos' => $permisos,
            ]
        );
    }
}

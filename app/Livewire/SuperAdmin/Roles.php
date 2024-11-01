<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public $open = false;
    public $name;

    #[Validate('required')]
    #[Validate("Unique:roles,name")]
    public $role;

    // protected $listeners = ['refreshComponent' => '$refresh'];

    public function cambiar($name)
    {
        $this->name = $name;


        $this->open = true;
    }

    public function crear()
    {
        $this->validate(
            [
                'role' => 'required',
            ]
        );

        Role::create([
            'name' => $this->role,
        ]);

        $this->role = '';
        $this->dispatch('post-created', name: "Se ha creado satisfactoriamente " . $this->name);

        $this->open = false;
    }

    public function render()
    {
        $totalRoles = Role::count();
        $totalPermisos = Permission::count();

        // Pasa estos datos a la vista
        return view('livewire.super-admin.roles', [
            'totalRoles' => $totalRoles,
            'totalPermisos' => $totalPermisos
        ]);
    }
}

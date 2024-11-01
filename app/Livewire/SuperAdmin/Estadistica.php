<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Estadistica extends Component
{
    public function render()
    {

        $totalRoles = Role::count();
        $totalUserP = User::count();
        $totalEstudinates = Estudiante::count();
        $totalDocente = Docente::count();

        // $totalDocentes = User::get('rol', 'docente')->count();
        return view(
            'livewire.super-admin.estadistica',
            [
                'totalRoles' => $totalRoles,
                'totalUserP' => $totalUserP,
                'totalEstudinates' => $totalEstudinates,
                'totalDocentes' => $totalDocente,
            ]
        );
    }
}

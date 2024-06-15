<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $roles = [
            'super-admin' => Role::create(['name' => 'super-admin']),
            'admin' => Role::create(['name' => 'admin']),
            'secretaria' => Role::create(['name' => 'secretaria']),
            'docente' => Role::create(['name' => 'docente']),
            'invitado' => Role::create(['name' => 'invitado']),
        ];

        // Crear permisos y asignarlos a roles
        $permissions = [
            'view user' => ['super-admin', 'admin'],
            'create user' => ['super-admin', 'admin'],
            'edit user' => ['super-admin', 'admin'],
            'delete user' => ['super-admin'],

            'view role' => ['super-admin', 'admin'],
            'create role' => ['super-admin', 'admin'],
            'edit role' => ['super-admin', 'admin'],
            'delete role' => ['super-admin'],

            'view permission' => ['super-admin', 'admin'],
            'create permission' => ['super-admin', 'admin'],
            'edit permission' => ['super-admin', 'admin', 'secretaria'],
            'delete permission' => ['super-admin'],

            'view curso' => ['super-admin', 'admin', 'secretaria', 'docente'],
            'create curso' => ['super-admin', 'admin'],
            'edit curso' => ['super-admin', 'admin', 'secretaria'],
            'delete curso' => ['super-admin'],

            'create cargo' => ['super-admin', 'admin'],
            'edit cargo' => ['super-admin', 'admin'],
            'delete cargo' => ['super-admin'],

            'votar' => ['invitado'],

            'ver votos' => ['super-admin', 'admin', 'secretaria', 'docente', 'invitado'],
            'inicar votacion' => ['super-admin', 'admin'],
            'cerrar votacion' => ['super-admin', 'admin'],
            'ver resultados' => ['super-admin', 'admin', 'secretaria', 'docente', 'invitado'],
        ];

        foreach ($permissions as $permissionName => $roleNames) {
            // Crear el permiso
            $permission = Permission::create(['name' => $permissionName]);

            // Asignar el permiso a los roles correspondientes
            foreach ($roleNames as $roleName) {
                $roles[$roleName]->givePermissionTo($permission);
            }
        }
    }
}

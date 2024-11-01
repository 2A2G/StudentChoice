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
        ];

        // Crear permisos y asignarlos a roles
        $permissions = [
            'view dashboard' => ['super-admin', 'admin', 'secretaria'],

            'view users' => ['super-admin', 'admin'],
            'create user' => ['super-admin', 'admin'],
            'edit user' => ['super-admin', 'admin'],
            'delete user' => ['super-admin'],

            'view estudiantes' => ['super-admin', 'admin', 'secretaria', 'docente'],
            'create estudiante' => ['super-admin', 'admin', 'secretaria'],
            'edit estudiante' => ['super-admin', 'admin', 'secretaria'],
            'delete estudiante' => ['super-admin'],

            'view docentes' => ['super-admin', 'admin', 'secretaria', 'docente'],
            'create docente' => ['super-admin', 'admin'],
            'edit docente' => ['super-admin', 'admin'],
            'delete docente' => ['super-admin'],

            'view roles' => ['super-admin', 'admin'],
            'create role' => ['super-admin', 'admin'],
            'edit role' => ['super-admin', 'admin'],
            'delete role' => ['super-admin'],

            'view permissions' => ['super-admin', 'admin'],
            'create permission' => ['super-admin', 'admin'],
            'edit permission' => ['super-admin', 'admin', 'secretaria'],
            'delete permission' => ['super-admin'],

            'view cargos' => ['super-admin', 'admin', 'secretaria'],
            'create cargos' => ['super-admin', 'admin'],
            'edit cargos' => ['super-admin', 'admin'],

            'view cursos' => ['super-admin', 'admin', 'secretaria', 'docente'],
            'create curso' => ['super-admin', 'admin'],
            'edit curso' => ['super-admin', 'admin', 'secretaria'],
            'delete curso' => ['super-admin'],

            'view panel votacion' => ['super-admin', 'admin', 'secretaria', 'docente'],
            'view postulacion' => ['super-admin', 'admin', 'secretaria'],
            'inicar votacion' => ['super-admin', 'admin'],
            'cerrar votacion' => ['super-admin', 'admin'],

            'ver resultados' => ['super-admin', 'admin', 'secretaria', 'docente'],
            'view historial votacion' => ['super-admin', 'admin', 'secretaria', 'docente'],
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

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
            'rector' => Role::create(['name' => 'rector']),
            'secretaria' => Role::create(['name' => 'secretaria']),
            'docente' => Role::create(['name' => 'docente']),
        ];

        // Crear permisos y asignarlos a roles
        $permissions = [
            'view dashboard' => ['super-admin', 'rector', 'secretaria'],

            'view users' => ['super-admin', 'rector'],
            'create user' => ['super-admin', 'rector'],
            'edit user' => ['super-admin', 'rector'],
            'delete user' => ['super-admin'],

            'view estudiantes' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'create estudiante' => ['super-admin', 'rector', 'secretaria'],
            'edit estudiante' => ['super-admin', 'rector', 'secretaria'],
            'delete estudiante' => ['super-admin'],

            'view docentes' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'create docente' => ['super-admin', 'rector'],
            'edit docente' => ['super-admin', 'rector'],
            'delete docente' => ['super-admin'],

            'view roles' => ['super-admin', 'rector'],
            'create role' => ['super-admin', 'rector'],
            'edit role' => ['super-admin', 'rector'],
            'delete role' => ['super-admin'],

            'view permissions' => ['super-admin', 'rector'],
            'create permission' => ['super-admin', 'rector'],
            'edit permission' => ['super-admin', 'rector', 'secretaria'],
            'delete permission' => ['super-admin'],

            'view cargos' => ['super-admin', 'rector', 'secretaria'],
            'create cargos' => ['super-admin', 'rector'],
            'edit cargos' => ['super-admin', 'rector'],

            'view cursos' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'create curso' => ['super-admin', 'rector'],
            'edit curso' => ['super-admin', 'rector', 'secretaria'],
            'delete curso' => ['super-admin'],

            'view panel votacion' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'view postulacion' => ['super-admin', 'rector', 'secretaria'],
            'inicar votacion' => ['super-admin', 'rector'],
            'cerrar votacion' => ['super-admin', 'rector'],

            'ver resultados' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'view historial votacion' => ['super-admin', 'rector', 'secretaria', 'docente'],
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

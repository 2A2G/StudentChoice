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

            'view students' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'create student' => ['super-admin', 'rector', 'secretaria'],
            'edit student' => ['super-admin', 'rector', 'secretaria'],
            'delete student' => ['super-admin'],

            'view teachers' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'create teacher' => ['super-admin', 'rector'],
            'edit teacher' => ['super-admin', 'rector'],
            'delete teacher' => ['super-admin'],

            'view roles' => ['super-admin', 'rector'],
            'create role' => ['super-admin', 'rector'],
            'edit role' => ['super-admin', 'rector'],
            'delete role' => ['super-admin'],

            'view permissions' => ['super-admin', 'rector'],
            'create permission' => ['super-admin', 'rector'],
            'edit permission' => ['super-admin', 'rector', 'secretaria'],
            'delete permission' => ['super-admin'],

            'view positions' => ['super-admin', 'rector', 'secretaria'],
            'create position' => ['super-admin', 'rector'],
            'edit position' => ['super-admin', 'rector'],

            'view courses' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'create course' => ['super-admin', 'rector'],
            'edit course' => ['super-admin', 'rector', 'secretaria'],
            'delete course' => ['super-admin'],

            'view voting panel' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'start voting' => ['super-admin', 'rector'],
            'close voting' => ['super-admin', 'rector'],

            'view results' => ['super-admin', 'rector', 'secretaria', 'docente'],
            
            'view voting history' => ['super-admin', 'rector', 'secretaria', 'docente'],
            'create election' => ['super-admin', 'rector', 'secretaria'],
            'edit election' => ['super-admin', 'rector', 'secretaria'],
            'delete election' => ['super-admin', 'rector', 'secretaria'],

            'view application' => ['super-admin', 'rector', 'secretaria'],
            'view applicants' => ['super-admin', 'rector', 'secretaria'],
            'create applicant' => ['super-admin', 'rector', 'secretaria'],
            'general deletion or editing' => ['super-admin', 'rector', 'secretaria'],

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

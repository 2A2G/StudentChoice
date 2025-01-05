<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(CursoSeeder::class);
        $this->call(CargoSeeder::class);
        $this->call(EstudianteSeeder::class);
        $this->call(DocenteSeeder::class);
        $this->call(ComicioSeeder::class);

        $superAdmin = User::create([
            'name' => 'Aldair',
            'email' => 'admin@inefrapasa.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $rector = User::create([
            'name' => 'Ricardo',
            'email' => 'Ricardo@inefrapasa.com',
            'password' => bcrypt('password'),
        ]);
        $rector->assignRole('rector');

        $secretaria = User::create([
            'name' => 'Julia',
            'email' => 'Julia@inefrapasa.com',
            'password' => bcrypt('password'),
        ]);
        $secretaria->assignRole('secretaria');
    }
}

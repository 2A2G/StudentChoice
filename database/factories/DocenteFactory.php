<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Docente>
 */
class DocenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userDocennte = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $userDocennte->assignRole('docente');
        return [
            'numero_identidad' => $this->faker->unique()->randomNumber(8),
            'user_id' => $userDocennte->id,
            'curso_id' => $this->faker->numberBetween(1, 10),
            'asignatura' => $this->faker->randomElement(['Matematicas', 'Lenguaje', 'Ciencias Naturales', 'Ciencias Sociales', 'Educacion Fisica', 'Tecnologia']),
            'sexo' => $this->faker->randomElement(['Masculino', 'Femenimo']),
        ];
    }
}

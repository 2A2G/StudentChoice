<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class EstudianteImport implements ToModel, WithHeadingRow
{
    use Importable;

    private $errores = [];

    public function model(array $row)
    {
        if (Estudiante::where('numero_identidad', $row['numero_identidad'])->exists()) {
            $this->errores[] = "Número de identidad duplicado: " . $row['numero_identidad'];
            return null;
        }

        return new Estudiante([
            'numero_identidad' => $row['numero_identidad'],
            'nombre_estudiante' => $row['nombre_estudiante'],
            'apellido_estudiante' => $row['apellido_estudiante'],
            'sexo' => $row['sexo'],
            'curso_id' => $row['curso_id'],
        ]);
    }

    public function getErrores()
    {
        return $this->errores;
    }
}

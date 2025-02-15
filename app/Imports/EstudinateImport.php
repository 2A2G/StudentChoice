<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;

class EstudinateImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Estudiante([
            'numero_identidad' => $row[0],
            'nombre_estudiante' => $row[1],
            'apellido_estudiante' => $row[2],
            'sexo' => $row[3],
            'curso_id' => $row[4],
        ]);
    }
}

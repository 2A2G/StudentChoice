<?php

namespace App\Services;

use App\Imports\EstudianteImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class StudentImportService
{

    public function importStudents($file): string
    {
        try {
            $import = new EstudianteImport();
            Excel::import($import, $file);

            $errores = $import->getErrores();
            if (!empty($errores)) {
                foreach ($errores as $error) {
                    Log::warning("Importación: " . $error);
                }
                return false;
            }
            return true;
        } catch (\Exception $e) {
            Log::error("Error en la importación: " . $e->getMessage());
            return false;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\StudentImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EstudianteController extends Controller
{
    protected $studentImportService;

    public function __construct(StudentImportService $studentImportService)
    {
        $this->studentImportService = $studentImportService;
    }

    public function sendStudents(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'importFile' => 'required|mimes:xlsx,xls',
            ]);

            $sendExcel = $this->studentImportService->importStudents($request->file('importFile'));

            if ($sendExcel) {
                return redirect()->route('viewEstudiantes')->with('post-created', 'Estudiantes importados correctamente.');
            } else {
                Log::error('Error al importar estudiantes');
                return redirect()->back()->with('error', 'Error al importar estudiantes.');
            }
        } catch (\Exception $e) {
            Log::error('Error en la importación: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error en la importación. Inténtalo de nuevo.');
        }
    }
}

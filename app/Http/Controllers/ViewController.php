<?php

namespace App\Http\Controllers;

use App\Models\Comicio;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function __construct()
    {
        //Gestión
        $this->middleware('can:view users')->only('usuarios');
        $this->middleware('can:view students')->only('estudiante');
        $this->middleware('can:view teachers')->only('docentes');
        $this->middleware('can:view roles and permission')->only('rolesPermisos');
        $this->middleware('can:view courses')->only('cursos');

        // Sistema de Votacion
        $this->middleware('can:view positions')->only('cargos');
        $this->middleware('can:view voting panel')->only('panelVotacion');
        $this->middleware('can:view voting history')->only('historialVotacion');
        $this->middleware('can:view applicants')->only('postulacion');
    }

    public function isLogged()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('welcome');
        }
    }

    public function welcome()
    {
        return view('livewire.welcome');
    }

    // Gestion
    public function index()
    {
        $caso = 'dashboard';
        return view('livewire.dashboard', compact('caso'));
    }

    public function usuarios()
    {
        $caso = 'usuarios';
        return view('livewire.dashboard', compact('caso'));
    }

    public function estudiante()
    {
        $caso = 'estudiante';
        return view('livewire.dashboard', compact('caso'));
    }

    public function docentes()
    {
        $caso = 'docentes';
        return view('livewire.dashboard', compact('caso'));
    }

    public function rolesPermisos()
    {
        $caso = 'rolesPermisos';
        return view('livewire.dashboard', compact('caso'));
    }

    public function cursos()
    {
        $caso = 'cursos';
        return view('livewire.dashboard', compact('caso'));
    }


    // Sistema de Votacion
    public function cargos()
    {
        $caso = 'cargos';
        return view('livewire.dashboard', compact('caso'));
    }

    public function panelVotacion()
    {
        $caso = 'panelVotacion';
        return view('livewire.dashboard', compact('caso'));
    }

    public function historialVotacion()
    {
        $caso = 'historialVotacion';
        return view('livewire.dashboard', compact('caso'));
    }

    public function postulacion()
    {
        $caso = 'postulacion';
        return view('livewire.dashboard', compact('caso'));
    }

    // Sistema no autenticado, solo para estudiantes
    public function sveEstudinate()
    {
        $caso = 'estudiante';
        return view('livewire.invitado.dashboard', compact('caso'));
    }

    public function votacion(Request $request)
    {
        $caso = 'votacion';

        $request->validate([
            'numero_identidad' => 'required|numeric',
        ], [
            'numero_identidad.required' => 'El número de identidad es obligatorio.',
            'numero_identidad.numeric' => 'El número de identidad debe ser un valor numérico.',
        ]);

        try {
            $comicio = Comicio::where('estado', true)->firstOrFail();

            if ($comicio->estado_eleccion !== true) {
                return back()->withErrors(['estado_eleccion' => 'Actualmente no hay elecciones activas disponibles.']);
            }

            $estudiante = Estudiante::where('numero_identidad', $request->numero_identidad)->first();
            if ($estudiante) {
                return view('livewire.invitado.dashboard', compact('caso', 'estudiante'));
            } else {
                return back()->withErrors(['numero_identidad' => 'No se encontró el estudiante o no está registrado.']);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->withErrors(['estado_eleccion' => 'No se encontró un comicio activo en este momento.']);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Hubo un error inesperado: ' . $th->getMessage()]);
        }
    }
}

<?php


use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::prefix('')->group(
    function () {
        Route::get('inefrapasa', [ViewController::class, 'welcome'])->name('welcome');
        Route::get('/', [ViewController::class, 'isLogged'])->name('home');
        Route::get('inefrapasa/estudiante', [ViewController::class, 'sveEstudinate'])->name('sveEstudinate');
        Route::get('inefrapasa/votacion', [ViewController::class, 'votacion'])->name('sveVotacion');
    }
);



Route::middleware(['auth'])->group(
    function () {
        Route::prefix('inefrapasa')->group(function () {
            Route::get('/dashboard', [ViewController::class, 'index'])->name('dashboard');

            Route::prefix('/gestion')->group(function () {
                Route::get('/rolesPermisos', [ViewController::class, 'rolesPermisos'])->name('rolesPermisos');
                Route::get('/usuarios', [ViewController::class, 'usuarios'])->name('usuarios');
                Route::get('/cursos', [ViewController::class, 'cursos'])->name('viewCursos');
                Route::get('/estudiante', [ViewController::class, 'estudiante'])->name('viewEstudiantes');
                Route::get('/docente', [ViewController::class, 'docentes'])->name('viewDocentes');
            });
            Route::prefix('/sistemaVotacion')->group(function () {
                Route::get('/cargos', [ViewController::class, 'cargos'])->name('viewCargos');
                Route::get('/votacion', [ViewController::class, 'panelVotacion'])->name('viewPanelVotacion');
                Route::get('/historial', [ViewController::class, 'historialVotacion'])->name('viewHistorialVotacion');
                Route::get('/postulacion', [ViewController::class, 'postulacion'])->name('viewPostulacion');
            });
        });
    }
);


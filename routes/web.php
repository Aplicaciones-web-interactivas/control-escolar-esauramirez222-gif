<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MaestroController;
use App\Http\Controllers\AlumnoController;


Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

Route::get('/registro', [AuthController::class, 'registro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registroGuardar'])->name('estudiantes.store');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    
    //Rutas del Admin
    Route::get('/admin/materias', [AdminController::class, 'indexMaterias'])->name('admin.materias');
    Route::get('/admin/horarios/crear', [AdminController::class, 'createHorario'])->name('admin.horarios.create');
    Route::post('/admin/horarios', [AdminController::class, 'storeHorario'])->name('admin.horarios.store');
    Route::get('/admin/grupos/crear', [AdminController::class, 'createGrupo'])->name('admin.grupos.create');
    Route::post('/admin/grupos', [AdminController::class, 'storeGrupo'])->name('admin.grupos.store');
    Route::post('/admin/materias', [AdminController::class, 'storeMateria'])->name('admin.materias.store');
    Route::put('/admin/materias/{id}', [AdminController::class, 'updateMateria'])->name('admin.materias.update');
    Route::delete('/admin/materias/{id}', [AdminController::class, 'destroyMateria'])->name('admin.materias.destroy');
    Route::get('/admin/maestros/crear', [App\Http\Controllers\AdminController::class, 'crearMaestro'])->name('admin.maestros.crear');
    Route::post('/admin/maestros', [App\Http\Controllers\AdminController::class, 'storeMaestro'])->name('admin.maestros.store');

    // Ruta del Maestro
    Route::get('/maestro/mis-clases', [MaestroController::class, 'misClases'])->name('maestro.clases');
    Route::get('/maestro/grupo/{id}', [App\Http\Controllers\MaestroController::class, 'verGrupo'])->name('maestro.grupo.ver');
    Route::post('/maestro/grupo/{id}/tarea', [App\Http\Controllers\MaestroController::class, 'storeTarea'])->name('maestro.tarea.store');
    Route::post('/maestro/calificar/{grupo_id}/{usuario_id}', [MaestroController::class, 'guardarCalificacion'])->name('maestro.calificar');
    Route::get('/maestro/tarea/{id}/entregas', [App\Http\Controllers\MaestroController::class, 'verEntregas'])->name('maestro.tarea.entregas');
    Route::post('/maestro/entrega/{id}/calificar', [App\Http\Controllers\MaestroController::class, 'calificarEntrega'])->name('maestro.entrega.calificar');

    // Ruta del Alumno
    Route::get('/alumno/mis-tareas', [AlumnoController::class, 'misTareas'])->name('alumno.tareas');
    Route::post('/alumno/tarea/{id}/entregar', [AlumnoController::class, 'subirTarea'])->name('alumno.tarea.subir');
    Route::get('/alumno/inscripciones', [App\Http\Controllers\AlumnoController::class, 'inscripciones'])->name('alumno.inscripciones');
    Route::post('/alumno/inscribir/{grupo_id}', [App\Http\Controllers\AlumnoController::class, 'inscribir'])->name('alumno.inscribir');
    Route::get('/alumno/calificaciones', [App\Http\Controllers\AlumnoController::class, 'calificaciones'])->name('alumno.calificaciones');

});
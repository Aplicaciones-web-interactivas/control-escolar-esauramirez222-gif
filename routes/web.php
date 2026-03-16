<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');//Puede buscar esta ruta con el nombre welcome, en lugar de usar la ruta /, esto es util para evitar errores al cambiar la ruta en el futuro

Route::get('/registro',[AuthController::class,'registro'])->name('registro');
Route::post('/registro',[AuthController::class,'registroGuardar'])->name('estudiantes.store');
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'loginPost'])->name('login.post');
Route::get('/admin/materias',[AdminController::class,'indexMaterias'])->name('admin.materias');
Route::get('/admin/horarios/crear', [AdminController::class, 'createHorario'])->name('admin.horarios.create');
Route::post('/admin/horarios', [AdminController::class, 'storeHorario'])->name('admin.horarios.store');
Route::get('/admin/grupos/crear', [AdminController::class, 'createGrupo'])->name('admin.grupos.create');
Route::post('/admin/grupos', [AdminController::class, 'storeGrupo'])->name('admin.grupos.store');
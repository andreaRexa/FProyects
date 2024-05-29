<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage; // Importar Storage facade
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CerrarSesionController;
use App\Http\Controllers\Auth\MiPerfilController;
use App\Http\Controllers\ProyectoController;

// Ruta principal
Route::get('/', function () {
    return view('home');
});

// Ruta Login y logout
Route::get('loginForm', [LoginController::class, 'showLoginForm'])->name('loginForm');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [CerrarSesionController::class, 'cerrarSession'])->name('logout');

// Ruta a mi perfil, actualización de datos y perfil
Route::get('MiPerfil', [MiPerfilController::class, 'showMiPerfil'])->name('MiPerfil');
Route::put('/perfil/{id}', [MiPerfilController::class, 'update'])->name('perfil.update');
Route::post('perfil/updatefoto', [MiPerfilController::class, 'updatefoto'])->name('perfil.updatefoto');

// Rutas relacionadas con proyectos
Route::get('proyectos', [ProyectoController::class, 'showListadoProyectos'])->name('proyectos');
Route::post('proyectos', [ProyectoController::class, 'filtrar'])->name('filtrado');
Route::post('proyectos', [ProyectoController::class, 'showListadoProyectosAlumno'])->name('proyectosAlumno');
Route::get('proyectos/{id}', [ProyectoController::class, 'showDetalleProyecto'])->name('proyectos.detalle');
Route::get('/descargar-archivo/{nombreProyecto}', [ProyectoController::class, 'descargarArchivo'])->name('descargarArchivo');
Route::get('/descargar-documentacion/{nombreProyecto}', [ProyectoController::class, 'descargarDocumentacion'])->name('descargarDocumentacion');


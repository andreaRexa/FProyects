<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage; // Importar Storage facade
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CerrarSesionController;
use App\Http\Controllers\Auth\MiPerfilController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\GestionesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RecContraseniaController;

// Ruta principal
Route::get('/', [HomeController::class, 'showHome']);

// Ruta Login y logout
Route::get('loginForm', [LoginController::class, 'showLoginForm'])->name('loginForm');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [CerrarSesionController::class, 'cerrarSession'])->name('logout');
Route::get('registroForm', [LoginController::class, 'registroForm'])->name('registroForm');
Route::post('registro', [LoginController::class, 'registro'])->name('registro');

//Ruta relacionada con la recuperacion de contraseña
Route::get('/pass-olvidada', [RecContraseniaController::class, 'showFormEmail'])->name('pass.olvidada');
Route::get('/pass-olvidada/cod', [RecContraseniaController::class, 'enviarCod'])->name('password.enviarcod');
Route::any('/pass-olvidada/reset-pass', [RecContraseniaController::class, 'resetPass'])->name('password.resetPass');


// Ruta a mi perfil, actualización de datos y perfil
Route::get('MiPerfil', [MiPerfilController::class, 'showMiPerfil'])->name('MiPerfil');
Route::put('/perfil/{id}', [MiPerfilController::class, 'update'])->name('perfil.update');
Route::post('perfil/updatefoto', [MiPerfilController::class, 'updatefoto'])->name('perfil.updatefoto');
Route::post('perfil/matriculacion', [MiPerfilController::class, 'matriculacion'])->name('matriculacion');
Route::get('/getCiclos/{idFamilia}', [MiPerfilController::class, 'getCiclos'])->name('getCiclos');

// Rutas relacionadas con proyectos
Route::get('proyectos', [ProyectoController::class, 'showListadoProyectos'])->name('proyectos');
Route::post('proyectosFiltrado', [ProyectoController::class, 'filtrar'])->name('filtrado');
Route::get('proyectosAlumno', [ProyectoController::class, 'showListadoProyectosAlumno'])->name('proyectosAlumno');
Route::get('proyectoFamilia', [ProyectoController::class, 'showListadoProyectosFamilia'])->name('proyectosAlumno');
Route::get('proyectos/{id}', [ProyectoController::class, 'showDetalleProyecto'])->name('proyectos.detalle');
Route::get('/descargar-archivo/{nombreProyecto}', [ProyectoController::class, 'descargarArchivo'])->name('descargarArchivo');
Route::get('/descargar-documentacion/{nombreProyecto}', [ProyectoController::class, 'descargarDocumentacion'])->name('descargarDocumentacion');

// Rutas relacionadas con gestiones
Route::get('gestionesModulos', [GestionesController::class, 'showListadoModulos'])->name('gestionesModulos');
Route::delete('/modulos/{id}', [GestionesController::class, 'eliminarModulo'])->name('modulos.eliminar');
Route::put('/modulos/editar', [GestionesController::class, 'nuevoEditarModulo'])->name('modulos.editar');


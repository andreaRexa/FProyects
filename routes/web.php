<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage; // Importar Storage facade
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CerrarSesionController;
use App\Http\Controllers\Auth\MiPerfilController;
use App\Http\Controllers\ProyectoController;

Route::get('/', function () {
    return view('/');
});

Route::get('FProyects', function () {
    return view('home');
});


Route::get('FProyects/loginForm', [LoginController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('FProyects/logout', [CerrarSesionController::class, 'cerrarSession'])->name('logout');
Route::get('FProyects/MiPerfil', [MiPerfilController::class, 'showMiPerfil'])->name('MiPerfil');
Route::put('/perfil/{id}', [MiPerfilController::class, 'update'])->name('perfil.update');
Route::post('perfil/updatefoto', [MiPerfilController::class, 'updatefoto'])->name('perfil.updatefoto');
Route::get('FProyects/proyectos', [ProyectoController::class, 'index'])->name('proyectos');

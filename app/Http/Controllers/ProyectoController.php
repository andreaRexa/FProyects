<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyectos; 

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::with('proyectoAlumno.usuario.alumnoCiclo')->get();
        return view('Proyectos.listaProyectos', compact('proyectos'));
    }
}

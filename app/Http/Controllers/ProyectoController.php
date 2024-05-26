<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyectos; 
use App\Models\Ciclo;
use App\Models\AlumnoCiclo;

class ProyectoController extends Controller
{
    public function showListadoProyectos()
    {
        $proyectos = Proyectos::with('proyectoAlumno.usuario.alumnoCiclo')->get();
        $ciclos = Ciclo::All(); 
        $cursos = AlumnoCiclo::All(); 
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
    }
}

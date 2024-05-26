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
        $ciclos = Ciclo::distinct()->get(); 
    $cursos = AlumnoCiclo::distinct()->get(); 
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
    }

    public function filtrar(Request $request)
    {
        // Obtener todos los proyectos
        $query = Proyectos::query();

        // Filtrar por nombre si se proporciona el parámetro "nombre" en la URL
        if ($request->has('nombre')) {
            $query->where('NombreProyecto', 'like', '%' . $request->input('nombre') . '%');
        }

        // Filtrar por descripción si se proporciona el parámetro "descripcion" en la URL
        if ($request->has('descripcion')) {
            $query->where('Descripcion', 'like', '%' . $request->input('descripcion') . '%');
        }

        // Filtrar por ciclo si se proporciona el parámetro "ciclo" en la URL
        if ($request->has('ciclo')) {
            $query->whereHas('proyectoAlumno.usuario.alumnoCiclo.ciclo', function ($q) use ($request) {
                $q->where('NombreCiclo', $request->input('ciclo'));
            });
        }

        // Filtrar por curso si se proporciona el parámetro "curso" en la URL
        if ($request->has('curso')) {
            $query->whereHas('proyectoAlumno.usuario.alumnoCiclo', function ($q) use ($request) {
                $q->where('FechaCurso', $request->input('curso'));
            });
        }
        dd($query);
        // Obtener los proyectos filtrados
        $proyectos = $query->get();
        $ciclos = Ciclo::distinct()->get(); 
        $cursos = AlumnoCiclo::distinct()->get(); 
        
        // Cargar la vista con los proyectos filtrados
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
    }

}

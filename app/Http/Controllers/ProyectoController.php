<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyectos; 
use App\Models\Ciclo;
use App\Models\AlumnoCiclo;
use App\Models\FamiliaAlumno;
use App\Models\AlumnoCurso;
use App\Models\Curso;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class ProyectoController extends Controller
{
    public function showListadoProyectos()
    {
        $proyectos = Proyectos::with('proyectoAlumno.usuario.alumnoCiclo')->get();
        $ciclos = Ciclo::groupBy('NombreCiclo')->pluck('NombreCiclo');
        $cursos = Curso::all(); 
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
    }

    public function showListadoProyectosAlumno(Request $request)
    {
        // Obtener el usuario logueado
        $userData = $request->session()->get('user');
        $alumnoId = $userData['id'];
    
        // Obtener los proyectos del alumno logueado
        $proyectos = Proyectos::with('proyectoAlumno.usuario.alumnoCiclo')
                               ->whereHas('proyectoAlumno', function($query) use ($alumnoId) {
                                   $query->where('IdUsuario', $alumnoId);
                               })->get();

        $ciclos = Ciclo::groupBy('NombreCiclo')->pluck('NombreCiclo');
        $cursos = Curso::all();  
    
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
    }

    public function showListadoProyectosFamilia(Request $request)
    {
        // Obtener el usuario logueado
        $userData = $request->session()->get('user');
        $IdAdmin = $userData['id'];

        // Obtener los proyectos del alumno logueado
        $proyectos = Proyectos::whereHas('familia', function ($query) use ($IdAdmin) {
            $query->where('IdAdministrador',$IdAdmin);
        })->get();

        $ciclos = Ciclo::groupBy('NombreCiclo')->pluck('NombreCiclo');
        $cursos = Curso::all(); 
    
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
    }

    public function showSubir(Request $request)
    {
        $userData = $request->session()->get('user');
        $alumnoId = $userData['id'];
        $familias = FamiliaAlumno::join('familias', 'familias.IdFamilia', '=', 'familialumno.IdFamilia')
                    ->where('IdUsuario', $alumnoId)
                    ->get();
        $ciclos = AlumnoCiclo::join('ciclos', 'ciclos.IdCiclo', '=', 'alumnociclo.IdCiclo')
                    ->where('IdUsuario', $alumnoId)
                    ->get();    
        $cursos = AlumnoCurso::join('cursos', 'cursos.IdCurso', '=', 'alumnocurso.IdCurso')
                    ->where('IdUsuario', $alumnoId)
                    ->get();   
        return view('Proyectos.SubirEditarProyectos', compact('familias', 'ciclos', 'cursos'));
    }

    public function obtenerAutores(Request $request){
        $familia = $request->input('familia');
        $ciclo = $request->input('ciclo');
        $curso = $request->input('curso');
    
        // Consulta Eloquent para obtener la lista de alumnos disponibles
        $alumnosDisponibles = Usuario::select('usuarios.IdUsuario', 'usuarios.Nombre')
            ->join('alumnociclo as acc', 'usuarios.IdUsuario', '=', 'acc.IdUsuario')
            ->join('alumnocurso as acur', 'usuarios.IdUsuario', '=', 'acur.IdUsuario')
            ->join('familialumno as fa', 'usuarios.IdUsuario', '=', 'fa.IdUsuario')
            ->where('acc.IdCiclo', $ciclo)
            ->where('acur.IdCurso', $curso)
            ->where('fa.IdFamilia', $familia)
            ->pluck('Nombre', 'IdUsuario');

        // Devolver la lista de alumnos disponibles como respuesta AJAX
        return response()->json($alumnosDisponibles);
    }

    public function filtrar(Request $request)
    {
        // Obtener todos los proyectos
        $query = Proyectos::query();

        // Filtrar por nombre 
        if ($request->filled('nombre')) {
            $query->whereRaw('LOWER(NombreProyecto) like ?', ['%' . strtolower($request->input('nombre')) . '%']);
        }
        
        // Filtrar por descripción 
        if ($request->filled('descripcion')) {
            $query->whereRaw('LOWER(Descripcion) like ?', ['%' . strtolower($request->input('descripcion')) . '%']);
        }

        // Filtrar por ciclo 
        if ($request->filled('ciclo')) {
            $query->whereHas('proyectoAlumno.usuario.alumnoCiclo.ciclo', function ($q) use ($request) {
                $q->whereRaw('LOWER(NombreCiclo) = ?', [strtolower($request->input('ciclo'))]);
            });
        }

        // Filtrar por curso
        if ($request->filled('curso')) {
            $query->where('IdCurso', $request->input('curso'));
        }
        
        // Obtener los proyectos filtrados
        $proyectos = $query->get();
        //dd($query->toSql());
        $ciclos = Ciclo::groupBy('NombreCiclo')->pluck('NombreCiclo');
        $cursos = Curso::all();  
        
        // Cargar la vista con los proyectos filtrados
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
    }

    public function showDetalleProyecto($id)
    {
        $proyecto = Proyectos::findOrFail($id);
        return view('Proyectos.InfoProyectos', compact('proyecto'));
    }

    
}

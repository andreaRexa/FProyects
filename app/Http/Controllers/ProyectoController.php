<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyectos; 
use App\Models\Ciclo;
use App\Models\AlumnoCiclo;
use Illuminate\Support\Facades\Storage;

class ProyectoController extends Controller
{
    public function showListadoProyectos()
    {
        $proyectos = Proyectos::with('proyectoAlumno.usuario.alumnoCiclo')->get();
        $ciclos = Ciclo::groupBy('NombreCiclo')->pluck('NombreCiclo');
        $cursos = AlumnoCiclo::groupBy('FechaCurso')->pluck('FechaCurso'); 
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
        $cursos = AlumnoCiclo::groupBy('FechaCurso')->pluck('FechaCurso'); 
    
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
        $cursos = AlumnoCiclo::groupBy('FechaCurso')->pluck('FechaCurso'); 
    
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
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
            $query->whereHas('proyectoAlumno.usuario.alumnoCiclo', function ($q) use ($request) {
                $q->where('FechaCurso', $request->input('curso'));
            });
        }
        
        // Obtener los proyectos filtrados
        $proyectos = $query->get();
        //dd($query->toSql());
        $ciclos = Ciclo::groupBy('NombreCiclo')->pluck('NombreCiclo');
        $cursos = AlumnoCiclo::groupBy('FechaCurso')->pluck('FechaCurso'); 
        
        // Cargar la vista con los proyectos filtrados
        return view('Proyectos.listaProyectos', compact('proyectos', 'ciclos', 'cursos'));
    }

    public function showDetalleProyecto($id)
    {
        $proyecto = Proyectos::findOrFail($id);
        return view('Proyectos.InfoProyectos', compact('proyecto'));
    }

    public function descargarArchivo($nombreProyecto)
    {
        // Buscar el proyecto por el nombre
        $proyecto = Proyectos::where('NombreProyecto', $nombreProyecto)->firstOrFail();
        $disco = 'archivosPublicos';
        // Construir la ruta completa del archivo
        $rutaCompleta = str_replace(' ', '_', $proyecto->NombreProyecto) . '/' . $proyecto->Archivos;
        // Descargar el archivo desde S3
        return Storage::disk($disco)->download($rutaCompleta);
    }

    public function descargarDocumentacion($nombreProyecto)
    {
        // Buscar el proyecto por el nombre
        $proyecto = Proyectos::where('NombreProyecto', $nombreProyecto)->firstOrFail();
    
        // Construir la ruta completa de la documentación
        $rutaCompleta = 'ArchivosPublicos/' . str_replace(' ', '_', $proyecto->NombreProyecto) . '/' . $proyecto->Documentacion;
        
        // Verificar si el archivo existe y obtener sus metadatos
        $exists = Storage::disk('s3')->exists($rutaCompleta);
        if (!$exists) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }
    
        // Obtener metadatos del archivo
        $metadata = Storage::disk('s3')->getMetadata($rutaCompleta);
        if (!$metadata) {
            return response()->json(['error' => 'No se pueden obtener los metadatos del archivo'], 500);
        }
    
        // Descargar la documentación desde S3
        try {
            return Storage::disk('s3')->download($rutaCompleta);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al descargar el archivo: ' . $e->getMessage()], 500);
        }
    }
    
}

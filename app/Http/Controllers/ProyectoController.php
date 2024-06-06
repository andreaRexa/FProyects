<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyectos; 
use App\Models\Ciclo;
use App\Models\AlumnoCiclo;
use App\Models\FamiliaAlumno;
use App\Models\ProyectoAlumno;
use App\Models\AlumnoCurso;
use App\Models\Curso;
use App\Models\Valoracion;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use App\Mail\ProyectoSubido;
use Illuminate\Support\Facades\Mail;

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
        $alumnosDisponibles = User::select('usuarios.IdUsuario', 'usuarios.Nombre')
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

    public function subirProyecto(Request $request)
    {
        try {
            $maxId = Proyectos::max('IdProyecto') + 1;

            // Validar los datos del formulario
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'archivos' => 'required|file', 
                'documentacion' => 'required|file', 
                'foto' => 'required|image', 
            ]);
        
            foreach ($request->autores as $autor) {
                $proyectoAlumno = new ProyectoAlumno();
                $proyectoAlumno->IdProyecto = $maxId;
                $proyectoAlumno->IdUsuario = $autor;
                $proyectoAlumno->save();
            }
          
            $proyecto = new Proyectos();
            $proyecto->IdProyecto = $maxId;
            $proyecto->NombreProyecto = $request->nombre;
            $proyecto->Descripcion = $request->descripcion;

            $estadoArch = $request->estado_archivos;
            // Manejar archivo de proyecto
            if ($request->hasFile('archivos')) {
                $archivo = $request->file('archivos');
                $archivoNombre = str_replace(' ', '_', $request->nombre) . '_' . $archivo->getClientOriginalName();
                $proyecto->Archivos = $archivoNombre;
            }
            $estadoDoc = $request->estado_documentos;
            // Manejar documentación del proyecto
            if ($request->hasFile('documentacion')) {

                $documentacion = $request->file('documentacion');
                $documentacionNombre = str_replace(' ', '_', $request->nombre) . '_' . $documentacion->getClientOriginalName();     
                $proyecto->Documentacion = $documentacionNombre;
            }
        
    
            // Manejar la imagen del proyecto
            if ($request->hasFile('foto')) {
                $proyecto->FotoProyecto = file_get_contents($request->file('foto')->getRealPath());
            }
    
            $proyecto->Estado = $request->estado_proyecto;
            $proyecto->Fecha = Carbon::now();
            $proyecto->IdCiclo = $request->ciclo;
            $proyecto->IdCurso = $request->curso;
            $proyecto->IdFamilia = $request->familia;
            $proyecto->ArchivosPriv = $request->estado_archivos;
            $proyecto->DocumentacionPriv = $request->estado_documentos;
            $proyecto->MediaValoracion = 0.00;
            $proyecto->save();
            
            Mail::to('andrea_rexa@outlook.es')->send(new ProyectoSubido($proyecto, $archivo, $archivoNombre,$estadoArch, $documentacion, $documentacionNombre,$estadoDoc));

            return redirect()->intended('proyectos')->with('success', 'Proyecto subido correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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

    public function subirProyectoS3(Request $request)
    {
        try {
            $maxId = Proyectos::max('IdProyecto') + 1;
    
            // Validar los datos del formulario
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'archivos' => 'required|file',
                'documentacion' => 'required|file',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            foreach ($request->autores as $autor) {
                $proyectoAlumno = new ProyectoAlumno();
                $proyectoAlumno->IdProyecto = $maxId;
                $proyectoAlumno->IdUsuario = $autor;
                $proyectoAlumno->save();
            }
    
            $proyecto = new Proyectos();
            $proyecto->IdProyecto = $maxId;
            $proyecto->NombreProyecto = $request->nombre;
            $proyecto->Descripcion = $request->descripcion;
    
            // Manejar archivo de proyecto
            if ($request->hasFile('archivos')) {
                $archivo = $request->file('archivos');
                $archivoNombre = str_replace(' ', '_', $request->nombre) . '_' . $archivo->getClientOriginalName();
                $archivoPath = $archivo->storeAs('proyectos/archivos', $archivoNombre, 's3');
                $proyecto->Archivos = Storage::disk('s3')->url($archivoPath);
            }
    
            // Manejar documentación del proyecto
            if ($request->hasFile('documentacion')) {
                $documentacion = $request->file('documentacion');
                $documentacionNombre = str_replace(' ', '_', $request->nombre) . '_' . $documentacion->getClientOriginalName();
                $documentacionPath = $documentacion->storeAs('proyectos/documentacion', $documentacionNombre, 's3');
                $proyecto->Documentacion = Storage::disk('s3')->url($documentacionPath);
            }
    
            // Manejar la imagen del proyecto
            if ($request->hasFile('foto')) {
                $proyecto->FotoProyecto = file_get_contents($request->file('foto')->getRealPath());
            }
    
            $proyecto->Estado = $request->estado_proyecto;
            $proyecto->Fecha = Carbon::now();
            $proyecto->IdCiclo = $request->ciclo;
            $proyecto->IdCurso = $request->curso;
            $proyecto->IdFamilia = $request->familia;
            $proyecto->ArchivosPriv = $request->estado_archivos;
            $proyecto->DocumentacionPriv = $request->estado_documentos;
            $proyecto->MediaValoracion = 0.00;
            $proyecto->save();

           

            return redirect()->intended('proyectos')->with('success', 'Proyecto subido correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    


    public function showDetalleProyecto($id)
    {
        $proyecto = Proyectos::findOrFail($id);
        return view('Proyectos.InfoProyectos', compact('proyecto'));
    }

    public function guardarValoracion(Request $request)
    {
        $request->validate([
            'valoracion' => 'required|integer|min:1|max:5',
            'proyectoId' => 'required|integer|exists:proyectos,IdProyecto',
        ]);

        $userData = $request->session()->get('user');
        $alumnoId = $userData['id'];
        $maxId = Valoracion::max('IdProyecto') + 1;
        $valoracion = new Valoracion();
        $valoracion->IdValoracion =   $maxId;
        $valoracion->IdUsuario = $alumnoId;
        $valoracion->Valoracion = $request->input('valoracion');
        $valoracion->IdProyecto = $request->input('proyectoId');
        $valoracion->FechaVal = Carbon::now();

        $valoracion->save();

        $proyectoId = $request->input('proyectoId');
        $proyecto = Proyectos::find($proyectoId);
        $media = Valoracion::where('IdProyecto', $proyectoId)->avg('Valoracion');

        $proyecto->MediaValoracion = round($media, 2);
        $proyecto->save();

        return response()->json(['message' => 'Valoración guardada y media actualizada correctamente']);
    }

    public function editarProyecto($id = null)
    {
        $proyecto = $id ? Proyectos::with('proyectoAlumno.usuario')->find($id) : null;
        $familias = Familia::all();
        $ciclos = Ciclo::all();
        $cursos = Curso::all();
        
        $autores = $proyecto ? $proyecto->proyectoAlumno->pluck('usuario') : collect();

        return view('Proyectos.subirEditarProyecto', compact('proyecto', 'familias', 'ciclos', 'cursos', 'autores'));
    }

    public function eliminarProyecto($id)
    {
        // Buscar el proyecto por su ID
        $proyecto = Proyectos::findOrFail($id);

        // Verificar si el usuario logueado es propietario del proyecto
        $userData = session()->get('user');
        $alumnoId = $userData['id'];

        if ($proyecto->proyectoAlumno->pluck('IdUsuario')->contains($alumnoId)) {
            // Eliminar el proyecto
            $proyecto->delete();

            // Redireccionar con un mensaje de éxito
            return redirect()->route('listaProyectos')->with('success', 'Proyecto eliminado exitosamente.');
        } else {
            // Redireccionar con un mensaje de error si el usuario no es propietario
            return redirect()->route('listaProyectos')->with('error', 'No tienes permiso para eliminar este proyecto.');
        }
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ciclo;
use App\Models\Curso;
use App\Models\Familia;
use App\Models\User;
use App\Models\FamiliaAlumno;
use App\Models\SolAlumnosPendientes;
class GestionesController extends Controller
{
    //Modulos
    public function showListadoModulos(Request $request)
    {
        // Obtener el usuario logueado
        $userData = $request->session()->get('user');
        $IdAdmin = $userData['id'];

        $ciclos = Ciclo::with('cursos.curso')
                            ->join('familias', 'ciclos.IdFamilia', '=', 'familias.IdFamilia')
                            ->select('ciclos.IdCiclo', 'ciclos.NombreCiclo', 'familias.NombreFamilia')
                            ->where('familias.IdAdministrador', $IdAdmin)
                            ->get(); 
        
        $cursosDisponibles = Curso::all();
        $IdFamilia=Familia::where('IdAdministrador', $IdAdmin)->pluck('IdFamilia')->first();
        return view('Gestiones.GestionModulos', compact('ciclos','cursosDisponibles','IdFamilia'));

        
    }

    public function eliminarModulo($id)
    {
        $modulo = Ciclo::findOrFail($id);
        $modulo->delete();
        return redirect()->back();
    }

    public function nuevoEditarModulo(Request $request)
    {
        
        if($request->accion === "nuevo"){
            $maxId = Ciclo::max('IdCiclo');
            // Crear un nuevo ciclo con los datos del formulario
            $ciclo = new Ciclo();
            $ciclo->IdCiclo = $maxId+1;
            $ciclo->NombreCiclo = $request->nombre;
            $ciclo->IdFamilia = $request->idfamilia;
            // Asignar otros atributos según sea necesario
            $ciclo->save();
            // Actualizar los cursos del ciclo
            // Primero, obtenemos los IDs de los cursos seleccionados desde el formulario
            $cursosDelCiclo = $request->cursosDelCiclo;
            // Eliminamos todos los cursos asociados actualmente
            $ciclo->cursos()->delete();
            
            if ($cursosDelCiclo!==null) {
                
                // Iteramos sobre los IDs de los cursos seleccionados y los creamos asociados al ciclo
                foreach ($cursosDelCiclo as $cursoId) {
                    $ciclo->cursos()->create(['IdCurso' => $cursoId]);
                }
            }
        }else{   
            // Buscar el ciclo por su ID
            $ciclo = Ciclo::findOrFail($request->ciclo_id);
            
            // Actualizar el nombre del ciclo con el valor enviado en el formulario
            $ciclo->NombreCiclo = $request->nombre;
            
            // Guardar los cambios en el ciclo
            $ciclo->save();
            // Actualizar los cursos del ciclo
            // Primero, obtenemos los IDs de los cursos seleccionados desde el formulario
            $cursosDelCiclo = $request->cursosDelCiclo;
            // Eliminamos todos los cursos asociados actualmente
            $ciclo->cursos()->delete();
            //dd($cursosDelCiclo);
            if ($cursosDelCiclo!==null) {
                // Iteramos sobre los IDs de los cursos seleccionados y los creamos asociados al ciclo
                foreach ($cursosDelCiclo as $cursoId) {
                    $ciclo->cursos()->create(['IdCurso' => $cursoId]);
                }
            }
        }

        return redirect()->back();
    }

    public function showListadoAlumnos(Request $request){
        // Obtener el usuario logueado
        $userData = $request->session()->get('user');
        $IdAdmin = $userData['id'];
        $alumnos = User::join('familialumno', 'usuarios.IdUsuario', '=', 'familialumno.IdUsuario')
                    ->join('familias', 'familias.IdFamilia', '=', 'familialumno.IdFamilia')
                    ->where('familias.IdAdministrador', $IdAdmin)
                    ->orderBy('usuarios.Apellidos') 
                    ->get(['usuarios.*']); 

        $usuarios = User::join('solAlumnosPendientes', 'usuarios.IdUsuario', '=', 'solAlumnosPendientes.IdUsuario')
                    ->join('ciclos', 'ciclos.IdCiclo', '=', 'solAlumnosPendientes.IdCiclo')
                    ->join('cursos', 'cursos.IdCurso', '=', 'solAlumnosPendientes.IdCurso')
                    ->join('familias', 'familias.IdFamilia', '=', 'solAlumnosPendientes.IdFamilia')
                    ->select(
                        'usuarios.FotoUsuario', 
                        'usuarios.Apellidos', 
                        'usuarios.Nombre', 
                        'usuarios.Correo', 
                        'usuarios.IdUsuario', 
                        'familias.IdFamilia', 
                        'ciclos.IdCiclo', 
                        'ciclos.Nombreciclo', 
                        'cursos.IdCurso', 
                        'solAlumnosPendientes.IdSolicitud', 
                        'cursos.Curso'
                    )
                    ->where('familias.IdAdministrador', $IdAdmin)
                    ->get();
        return view('Gestiones.GestionesAlumnos', compact('alumnos','usuarios'));

    }

    public function eliminarSol(Request $request){
        // Obtener los IDs de los elementos a eliminar desde la solicitud
        $IdSolicitud = $request->IdSolicitud;
        //dd($idUsuario, $idFamilia, $idCiclo, $idCurso);

        // Buscar la solicitud en la base de datos utilizando los IDs
        $solicitud = SolAlumnosPendientes::get($IdSolicitud);
        //dd($solicitud);
        // Eliminar la solicitud
        $solicitud->delete();
        
        return redirect()->intended('gestionesAlumnos');
    }
}

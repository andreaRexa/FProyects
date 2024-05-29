<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ciclo;
use App\Models\Curso;

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
                                ->select('ciclos.IdCiclo', 'ciclos.NombreCiclo', 'familias.NombreFamilia','familias.IdFamilia')
                                ->where('familias.IdAdministrador', $IdAdmin)
                                ->get(); 
        //dd($ciclosConCursos);
        
        $cursosDisponibles = Curso::all();
        return view('Gestiones.GestionModulos', compact('ciclos','cursosDisponibles'));

        
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
            // Crear un nuevo ciclo con los datos del formulario
            $ciclo = new Ciclo();
            $ciclo->NombreCiclo = $request->nombre;
            $ciclo->IdFamilia = $request->idfamilia;
            // Asignar otros atributos según sea necesario
            $ciclo->save();

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
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ciclo;

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
        //dd($ciclosConCursos);
        
        $cursosDisponibles = Cursos::all();
        return view('Gestiones.GestionModulos', compact('ciclos','cursosDisponibles'));

        
    }

    public function eliminarModulo($id)
    {
        $modulo = Ciclo::findOrFail($id);
        $modulo->delete();
        return redirect()->back();
    }

    public function editarModulo(Request $request, $id)
    {
        // Lógica para editar el módulo...
        
        return redirect()->back();
    }
}

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
        return view('Gestiones.GestionModulos', compact('ciclos'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GestionesController extends Controller
{
    //Modulos
    public function showListadoModulos()
    {
        $ciclosConCursos = Ciclo::with('cursos')
                                ->join('familia', 'ciclo.IdFamilia', '=', 'familia.IdFamilia')
                                ->select('ciclo.IdCiclo', 'ciclo.NombreCiclo', 'familia.NombreFamilia')
                                ->get(); 

        return view('Gestiones.GestionModulos', compact('ciclosConCursos'));
    }
}

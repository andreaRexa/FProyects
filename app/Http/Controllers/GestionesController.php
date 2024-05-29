<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ciclo;

class GestionesController extends Controller
{
    //Modulos
    public function showListadoModulos()
    {
        $ciclosConCursos = Ciclo::with('cursos')
                                ->join('familias', 'ciclo.IdFamilia', '=', 'familias.IdFamilia')
                                ->select('ciclo.IdCiclo', 'ciclo.NombreCiclo', 'familias.NombreFamilia')
                                ->get(); 

        return view('Gestiones.GestionModulos', compact('ciclosConCursos'));
    }
}

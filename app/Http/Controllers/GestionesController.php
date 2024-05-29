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
                                ->join('familias', 'ciclos.IdFamilia', '=', 'familias.IdFamilia')
                                ->select('ciclos.IdCiclo', 'ciclos.NombreCiclo', 'familias.NombreFamilia')
                                ->get(); 
        dd($ciclosConCursos);
        return view('Gestiones.GestionModulos', compact('ciclosConCursos'));
    }
}

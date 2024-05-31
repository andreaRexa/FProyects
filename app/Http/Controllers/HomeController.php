<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyectos; 

class HomeController extends Controller
{
    function showHome () {
        $proyectos = Proyectos::withCount('valoraciones') // Contar el número de valoraciones por proyecto
                    ->orderByDesc('MediaValoracion') // Ordenar por MediaValoracion de forma descendente
                    ->orderByDesc('valoraciones_count') // Si hay proyectos con la misma MediaValoracion, ordenar por número de valoraciones
                    ->limit(5) // Limitar a los primeros 5 proyectos
                    ->get();
        return view('home',compact('proyectos'));
    }
}

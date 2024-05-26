<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CerrarSesionController extends Controller
{
    public function cerrarSession(Request $request)
    {
        Session::flush();
        return redirect()->intended('/');
    }
}

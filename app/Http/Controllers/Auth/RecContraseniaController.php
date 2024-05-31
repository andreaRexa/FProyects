<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Http\Controllers\Auth\Str;

class RecContraseniaController extends Controller
{
    function showFormEmail () {
        return view('Auth.RecContraseñaEmail');
    }

    function enviarCod (Request $request) {

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('correo', $request->email)->first();

        // Generar y guardar un código de recuperación
        $code = Str::random(6);
        User::updateOrCreate(
            ['Correo' => $user->Correo],
            ['CodRecContr' => Hash::make($code)]
        );

        // Enviar el código de recuperación por correo electrónico
        Mail::to($user->Correo)->send(new ResetPasswordMail($code));

        return view('Auth.RecContraseña');
    }

    
}

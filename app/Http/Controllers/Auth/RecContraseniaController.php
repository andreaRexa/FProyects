<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 

class RecContraseniaController extends Controller
{
    function showFormEmail () {
        return view('Auth.RecContraseñaEmail');
    }

    function enviarCod (Request $request) {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('correo', $request->email)->first();

        // Generar y guardar un código de recuperación
        $code = Str::random(6);
        User::updateOrCreate(
            ['email' => $user->correo],
            ['code' => Hash::make($code)]
        );

        // Enviar el código de recuperación por correo electrónico
        Mail::to($user->correo)->send(new ResetPasswordMail($code));

        return redirect()->route('password.reset', ['email' => $user->email]);

        return view('Auth.RecContraseña');
    }

    
}

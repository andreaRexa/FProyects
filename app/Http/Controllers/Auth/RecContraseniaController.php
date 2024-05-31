<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;

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
        $code = mt_rand(100000, 999999);
        User::updateOrCreate(
            ['Correo' => $user->Correo],
            ['CodRecContr' => $code]
        );

        // Enviar el código de recuperación por correo electrónico
        Mail::to($user->Correo)->send(new ResetPasswordMail($code));

        return view('Auth.RecContraseña');
    }

    
}

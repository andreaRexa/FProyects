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

        return view('Auth.RecContraseña',['email' => $user->Correo]);
    }

    public function resetPass(Request $request)
    {
        //dd($request);
        $request->validate([
            'email' => 'required|email',
            'codigo' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
        ]);

        $User = User::where('Correo', $request->email)->first();
        //dd($request->codigo,intval($request->codigo), $User->CodRecContr, gettype($request->codigo), gettype($User->CodRecContr),intval($request->codigo) === $User->CodRecContr);
        // Verificar si el código de recuperación es válido
        
        if (intval($request->codigo) === $User->CodRecContr) {
            // Actualizar la contraseña del usuario
            $User->password = bcrypt($request->password);
            // Eliminar el código de recuperación
            $User->CodRecContr = 0;


            $User->save();
            return redirect()->route('loginForm')->with('success', '¡Tu contraseña ha sido restablecida correctamente!');
        } else {
            return redirect()->route('password.resetPass')->withErrors(['codigo' => 'El código de recuperación es inválido. Por favor, inténtalo de nuevo.']);
        }
    } 
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class LoginController extends Controller
{
    protected function guard()
    {
        return Auth::guard();
    }

    // Método para mostrar el formulario de inicio de sesión
    public function showLoginForm(Request $request)
    {
        return view('Auth.login', ['btnlogin' => $request->query('btnlogin')]);
    }

    // Método para manejar el proceso de inicio de sesión
    public function login(Request $request)
    {

        // Obtener las credenciales de la solicitud
        $credentials = $request->only('Correo', 'password');
        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            // Autenticación exitosa
            $request->session()->regenerate(); // Regenerar el ID de la sesión para evitar el secuestro de sesión
            $user = Auth::user(); // Obtener el usuario autenticado

            // Guardar solo los campos deseados del usuario en la sesión
            $userData = [
                'id' => $user->IdUsuario,
                'nombre' => $user->Nombre,
                'apellidos' => $user->Apellidos,
                'email' => $user->Correo,
                'rol' => $user->TipoUsuario,
                'foto' => $user->FotoUsuario,
                'fecha_creacion' => $user->FechaCreacion,
            ];

            $request->session()->put('user', $userData); // Guardar los datos del usuario en la sesión
            return redirect()->intended('FProyects'); // Redirigir a la ruta deseada después del inicio de sesión
        } else {
            // Autenticación fallida
            return back()->withErrors(['Correo' => 'Credenciales inválidas'])->withInput();
        }
    }
}
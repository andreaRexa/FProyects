<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Carbon;

class LoginController extends Controller
{
    protected function guard()
    {
        return Auth::guard();
    }
    
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
                'NIA' => $user->NIA
            ];

            $request->session()->put('user', $userData); // Guardar los datos del usuario en la sesión
            return redirect()->intended('/'); 
        } else {
            // Autenticación fallida
            return back()->withErrors(['Correo' => 'Credenciales inválidas'])->withInput();
        }
    }

    public function registro(Request $request)
    {
        // Verificar si el correo electrónico ya existe en la base de datos
        $existingUser = User::where('Correo', $request->Correo)->first();

        if ($existingUser) {
            // Si el correo electrónico ya existe, redirige de vuelta al formulario de registro con un mensaje de error
            return redirect()->back()->withErrors(['Correo' => 'El correo electrónico ya está en uso.'])->withInput();
        }

        // Validar la solicitud
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Apellidos' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'FotoUsuario' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'Correo' => 'required|string|email|max:255',
        ]);

        // Manejar la carga de la foto de usuario
        if ($request->hasFile('FotoUsuario')) {
            $fotoUsuario = file_get_contents($request->file('FotoUsuario'));
        } else {
            $fotoUsuario = file_get_contents(public_path('storage/imagenes/userdefecto.png'));
        }

        // Crear el usuario
        $maxId = User::max('IdUsuario');
        $user = new User();
        $user->IdUsuario = $maxId + 1;
        $user->Nombre = $request->Nombre;
        $user->Apellidos = $request->Apellidos;
        $user->password = bcrypt($request->password);
        $user->FotoUsuario = $fotoUsuario;
        $user->TipoUsuario = 1;
        $user->CodRecContr = 0;
        $user->NIA = 0;
        $user->FechaCreacion = Carbon::now();
        $user->Correo = $request->Correo;

        $user->save();
        // Redireccionar con un mensaje de éxito
        return redirect()->route('loginForm')->with('success', 'Registro exitoso. Por favor, inicia sesión.');
    }

    public function registroForm(Request $request)
    {
        return view('Auth.Registro');
    }
}
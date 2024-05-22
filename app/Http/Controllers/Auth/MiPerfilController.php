<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Storage;

class MiPerfilController extends Controller
{
    public function showMiPerfil(Request $request)
    {
        $userData = $request->session()->get('user');
        $user = User::findOrFail($userData['id']);
        $fotourl=$user->FotoUsuario;
        $imagenURL = Storage::disk('s3')->url('FotosPerfil/'.$fotourl);

        return view('Auth.MiPerfil', ['imagenURL' => $imagenURL]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Actualizar los datos del usuario con los datos del formulario
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->correo = $request->email;
        
        $user->save();
    
        // Obtener los datos actualizados del usuario de la base de datos
        $updatedUser = User::find($id);
        
        if ($updatedUser) {
            // Actualizar los valores correspondientes en la sesión con los nuevos datos
            $request->session()->put('user.nombre', $updatedUser->Nombre);
            $request->session()->put('user.apellidos', $updatedUser->Apellidos);
            $request->session()->put('user.email', $updatedUser->Correo);
    
            // Redireccionar al usuario a una página de confirmación o a donde desees
            return redirect()->route('MiPerfil')->with('success', 'Perfil actualizado correctamente.');
        } else {
            // Manejar el caso en que no se pueda encontrar al usuario actualizado
            return redirect()->route('MiPerfil')->with('error', 'No se pudo actualizar el perfil. Inténtalo de nuevo.');
        }
    }
    
    
}

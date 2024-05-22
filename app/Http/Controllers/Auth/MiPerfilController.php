<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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

    public function updatefoto(Request $request)
{
    // Validar la foto de perfil
    $request->validate([
        'foto_perfil' => 'required|mimes:jpg,jpeg,png|max:2048', // Permitir solo JPG y PNG, tamaño máximo de 2MB
    ]);

    $userData = $request->session()->get('user');
    $user = User::findOrFail($userData['id']);

    // Subir la nueva foto de perfil
    if ($request->hasFile('foto_perfil')) {
        $file = request('foto_perfil');
        $filename = Str::lower($user->Nombre) . '.' . $request->file('foto_perfil')->getClientOriginalExtension();
        $path = 'FotosPerfil';

        try {
            $uploaded = $request->file('foto_perfil')->storeAs($path,$filename, 's3');
            if ($uploaded) {
                // Actualizar el nombre de la foto en la base de datos
                $user->FotoUsuario = $filename;
                $user->save();

                // Obtener la URL actualizada de la foto de perfil del usuario
                $fotourl = $user->FotoUsuario;
                $imagenURL = Storage::disk('s3')->url('FotosPerfil/' . $fotourl);

                // Actualizar la URL de la foto de perfil en la sesión
                $request->session()->put('user.foto', $imagenURL);

                // Redireccionar o retornar la vista con la URL de la imagen actualizada
                return view('Auth.MiPerfil', ['imagenURL' => $imagenURL]);
            } else {
                Log::error('Failed to upload file to S3');
                return redirect()->route('MiPerfil')->with('error', 'No se pudo subir la foto de perfil. Inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            Log::error('S3 upload error: ' . $e->getMessage());
            return redirect()->route('MiPerfil')->with('error', 'Ocurrió un error al subir la foto de perfil. Inténtalo de nuevo.');
        }
    }
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

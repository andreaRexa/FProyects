<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Familia; 
use App\Models\Ciclo; 
use App\Models\CicloCurso; 
use App\Models\SolAlumnosPendientes; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MiPerfilController extends Controller
{
    public function showMiPerfil(Request $request)
    {
        $userData = $request->session()->get('user');
        $user = User::findOrFail($userData['id']);
        $fotoBlob = $user->FotoUsuario;

        $imagenURL = $fotoBlob ? 'data:image/jpeg;base64,' . base64_encode($fotoBlob) : null;
        $familias = Familia::all();
        return view('Auth.MiPerfil', compact( 'imagenURL','familias'));
    }

    public function getCiclos($idFamilia)
    {
        $ciclos = Ciclo::where('IdFamilia', $idFamilia)->get();
        return response()->json($ciclos);
    }

    public function getCursos($idCiclo)
    {
        $cicloCurso = CicloCurso::where('IdCiclo', $idCiclo)->with('curso')->get();
        $cursos = $cicloCurso->pluck('curso');
        return response()->json($cursos);
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
            $file = $request->file('foto_perfil');
            $fileContents = file_get_contents($file);

            // Actualizar el campo BLOB en la base de datos
            $user->FotoUsuario = $fileContents;
            $user->save();
        }

        // Obtener la URL actualizada de la foto de perfil del usuario
        $fotoBlob = $user->FotoUsuario;
        $imagenURL = $fotoBlob ? 'data:image/jpeg;base64,' . base64_encode($fotoBlob) : null;

        return view('Auth.MiPerfil', ['imagenURL' => $imagenURL]);
    }

    public function update(Request $request, $id)
    {
        // Verificar si el correo electrónico ya existe en la base de datos
        $existingUser = User::where('Correo', $request->email)->first();

        if ($existingUser) {
            // Si el correo electrónico ya existe, redirige de vuelta al formulario de registro con un mensaje de error
            return redirect()->back()->withErrors(['Correo' => 'El correo electrónico ya está en uso.'])->withInput();
        }
        
        // Validar la solicitud
        $request->validate([
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
        ]);
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
            return redirect()->route('MiPerfil')->with('success', 'Perfil actualizado correctamente.');
        } else {
            return redirect()->route('MiPerfil')->with('error', 'No se pudo actualizar el perfil. Inténtalo de nuevo.');
        }
    }
    
    public function matriculacion (Request $request){
        // Verificar si la pass de la contreseña de la familia es correcta
        $passFamilia = Familia::where('ContraseniaFamilia', $request->passFamilia)->first();

        if ($existingUser) {
            // Si el correo electrónico ya existe, redirige de vuelta al formulario de registro con un mensaje de error
            return redirect()->back()->withErrors(['passFamilia' => 'La contraseña de la famila es erronea'])->withInput();
        }
        
        // Validar la solicitud
        $request->validate([
                'passFamilia' => 'required|string|max:16',
        ]);
        $solicitud = new SolAlumnosPendientes();
        $userData = $request->session()->get('user');
        $solicitud->IdUsuario = $userData['id'];
        $solicitud->IdFamilia = $request->selectFamilia;
        $solicitud->IdCiclo = $request->selectModulos;
        $solicitud->IdCurso = $request->selectCursos;
        $solicitud->save;
    }
}

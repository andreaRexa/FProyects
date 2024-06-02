<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Familia; 
use App\Models\Ciclo; 
use App\Models\CicloCurso; 
use App\Models\Alumnociclo; 
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

    public function getCiclos($idFamilia, Request $request)
    {
        $userData = $request->session()->get('user');
    
        // Obtener los ciclos que el usuario no ha matriculado previamente
        $ciclosDisponibles = Ciclo::whereNotIn('IdCiclo', function ($query) use ($idFamilia, $userData) {
            $query->select('IdCiclo')
                ->from('alumnociclo')
                ->where('IdUsuario', $userData['id']);
        })
        ->where('IdFamilia', $idFamilia)
        ->get();
    
        return response()->json($ciclosDisponibles);
    }
    
    public function getCursos($idCiclo, Request $request)
    {
        $userData = $request->session()->get('user');
    
        // Obtener los cursos que el usuario no ha matriculado previamente en el ciclo seleccionado
        $cursosDisponibles = Curso::whereNotIn('IdCurso', function ($query) use ($idCiclo, $userData) {
            $query->select('IdCurso')
                ->from('alumnocurso')
                ->where('IdCiclo', $idCiclo)
                ->where('IdUsuario', $userData['id']);
        })
        ->whereIn('IdCurso', function ($query) use ($idCiclo) {
            $query->select('IdCurso')
                ->from('ciclocurso')
                ->where('IdCiclo', $idCiclo);
        })
        ->get();
    
        return response()->json($cursosDisponibles);
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
    
    public function matriculacion(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'passFamilia' => 'required|string|max:16',
        ]);
    
        // Verificar si la contraseña de la familia es correcta
        $passFamilia = Familia::where('ContraseniaFamilia', $request->passFamilia)->first();
    
        if (!$passFamilia) {
            // Si la contraseña de la familia es incorrecta, redirige de vuelta al formulario de matriculación con un mensaje de error
            return redirect()->back()->withErrors(['passFamilia' => 'La contraseña de la familia es incorrecta'])->withInput();
        }
    
        // Verificar si ya existe una solicitud pendiente para el mismo usuario y la misma familia
        $userData = $request->session()->get('user');
        $existingSolicitud = SolAlumnosPendientes::where('IdUsuario', $userData['id'])
                                ->where('IdFamilia', $request->selectFamilia)
                                ->exists();

        if ($existingSolicitud) {
            // Si ya existe una solicitud pendiente, redirige de vuelta al formulario de matriculación con un mensaje de error
            return redirect()->back()->withErrors(['error' => 'Ya tienes una solicitud pendiente para esta familia'])->withInput();
        }
        $maxId = SolAlumnosPendientes::max('IdSolicitud');
        // Crear y guardar la solicitud
        $solicitud = new SolAlumnosPendientes();
        $solicitud->IdSolicitud =$maxId+1;
        $solicitud->IdUsuario = $userData['id'];
        $solicitud->IdFamilia = $request->selectFamilia;
        $solicitud->IdCiclo = $request->selectModulos;
        $solicitud->IdCurso = $request->selectCursos;
    
        try {
            $solicitud->save();
            return redirect()->route('MiPerfil')->with('success', 'Solicitud enviada');
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso de guardado
            return redirect()->back()->withErrors(['error' => 'Ha ocurrido un error al enviar la solicitud. Por favor, intenta de nuevo más tarde.'])->withInput();
        }
    }
    
}

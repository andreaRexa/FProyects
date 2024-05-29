<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EncryptExistingPasswords2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Asumimos que las contraseñas están almacenadas en la tabla `users` en la columna `password`
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // Verifica si la contraseña no está ya encriptada (esto depende de cómo estaban almacenadas antes)
            // Este ejemplo asume que las contraseñas no encriptadas son texto plano.
            // Debes ajustar esta lógica según tu caso específico.
            if (strlen($user->password) < 60) {
                DB::table('users')
                    ->where('IdUsuario', $user->IdUsuario)
                    ->update(['password' => Hash::make($user->password)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No se puede revertir el hashing de contraseñas porque bcrypt es unidireccional
        // Por lo tanto, no hacemos nada aquí
    }
}


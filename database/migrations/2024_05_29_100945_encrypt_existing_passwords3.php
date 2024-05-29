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
        $users = DB::table('usuarios')->get();

        foreach ($users as $user) {
            if (strlen($user->password) < 60) {
                DB::table('usuarios')
                    ->where('IdUsuario', $user->IdUsuario)
                    ->update(['password' => bcrypt($user->password)]);
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


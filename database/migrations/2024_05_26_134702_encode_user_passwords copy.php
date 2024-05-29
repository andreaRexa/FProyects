<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EncodeUserPasswords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Fetch all users
        $users = DB::table('usuarios')->get();

        // Update each user's password to be hashed
        foreach ($users as $user) {
            DB::table('usuarios')
                ->where('IdUsuario', $user->IdUsuario)
                ->update(['password' => bcrypt($user->password)]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you could reverse the hashed passwords here
        // if you have stored the plain text passwords somewhere secure.
    }
}

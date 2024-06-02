<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
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
     */
    public function down(): void
    {
        //
    }
};

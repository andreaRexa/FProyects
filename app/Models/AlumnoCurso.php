<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoCurso extends Model
{
    use HasFactory;
    protected $table = 'alumnocurso';
    protected $primaryKey = ['IdUsuario', 'IdCurso'];
    public $incrementing = false;
    public $timestamps = false;


    public function curso()
    {
        return $this->belongsTo(Curso::class, 'IdCurso', 'IdCurso');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario', 'IdUsuario');
    }
}

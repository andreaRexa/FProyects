<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicloCurso extends Model
{
    use HasFactory;

    protected $table = 'cicloscursos';
    public $timestamps = false; 

    protected $fillable = [
        'IdCiclo',
        'IdCurso',
    ];

    // Relación con el modelo Ciclo
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'IdCiclo', 'IdCiclo');
    }

    // Relación con el modelo Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'IdCurso', 'IdCurso');
    }
}

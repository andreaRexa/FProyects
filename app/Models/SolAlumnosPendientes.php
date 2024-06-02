<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolAlumnosPendientes extends Model
{
    use HasFactory;

    protected $table = 'solAlumnosPendientes';
    public $timestamps = false;

    protected $fillable = [
        'IdUsuario',
        'IdFamilia',
        'IdCiclo',
        'IdCurso'
    ];

    protected $primaryKey = ['IdUsuario', 'IdFamilia', 'IdCiclo', 'IdCurso'];
    public $incrementing = false;

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario', 'IdUsuario');
    }

    // Relación con el modelo Familia
    public function familia()
    {
        return $this->belongsTo(Familia::class, 'IdFamilia', 'IdFamilia');
    }

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoCiclo extends Model
{
    use HasFactory;

    protected $table = 'alumnociclo';
    public $timestamps = false; 
    protected $primaryKey = ['IdUsuario', 'IdCiclo'];
    public $incrementing = false;

    protected $fillable = [
        'IdUsuario',
        'IdCiclo',
        'FechaCurso',
    ];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario', 'IdUsuario');
    }

    // Relación con el modelo Ciclo
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'IdCiclo', 'IdCiclo');
    }
}

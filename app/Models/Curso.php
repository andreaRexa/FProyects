<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $primaryKey = 'IdCurso';

    protected $fillable = [
        'Curso'
    ];
    
    public function ciclos()
    {
        return $this->belongsToMany(Ciclo::class, 'cicloscursos', 'IdCurso', 'IdCiclo');
    }
}

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

    // Relación con el modelo cicloscurso
    public function ciclos()
    {
        return $this->belongsToMany(CicloCurso::class, 'IdCurso', 'IdCurso');
    }
}

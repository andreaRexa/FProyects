<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $table = 'ciclos';
    protected $primaryKey = 'IdCiclo';
    public $timestamps = false; // Si la tabla no tiene timestamps (created_at, updated_at)

    protected $fillable = [
        'NombreCiclo',
        'IdFamilia',
    ];

    // Relación con el modelo Familia
    public function familia()
    {
        return $this->belongsTo(Familia::class, 'IdFamilia', 'IdFamilia');
    }
    
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'cicloscursos', 'IdCiclo', 'IdCurso');
    }
}

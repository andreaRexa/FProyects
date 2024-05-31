<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $table = 'ciclos';
    protected $primaryKey = 'IdCiclo';
    public $timestamps = false; 

    protected $fillable = [
        'NombreCiclo',
        'IdFamilia',
    ];

    // Relación con el modelo Familia
    public function familia()
    {
        return $this->belongsTo(Familia::class, 'IdFamilia', 'IdFamilia');
    }

    // Relación con el modelo ciclocurso
    public function cursos()
    {
        return $this->hasMany(CicloCurso::class, 'IdCiclo', 'IdCiclo');
    }
}

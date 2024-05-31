<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamiliaAlumno extends Model
{
    use HasFactory;

    protected $table = 'familialumno';
    public $timestamps = false; 
    protected $primaryKey = ['IdFamilia', 'IdUsuario'];
    public $incrementing = false;

    protected $fillable = [
        'IdFamilia',
        'IdUsuario',
    ];

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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    use HasFactory;

    protected $table = 'familias';
    protected $primaryKey = 'IdFamilia';
    public $timestamps = false; 

    protected $fillable = [
        'NombreFamilia',
        'ContraseniaFamilia',
        'IdAdministrador',
    ];

    // Relación con el modelo Usuario para el administrador de la familia
    public function administrador()
    {
        return $this->belongsTo(User::class, 'IdAdministrador', 'IdUsuario');
    }
}
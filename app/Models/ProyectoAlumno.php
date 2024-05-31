<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoAlumno extends Model
{
    use HasFactory;

    protected $table = 'proyectoalumno';
    public $timestamps = false;
    protected $primaryKey = ['IdProyecto', 'IdUsuario'];
    public $incrementing = false;

    protected $fillable = [
        'IdProyecto',
        'IdUsuario',
    ];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario', 'IdUsuario');
    }

    // Relación con el modelo Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyectos::class, 'IdProyecto', 'IdProyecto');
    }
}

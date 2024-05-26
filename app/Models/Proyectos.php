<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    protected $primaryKey = 'IdProyecto';
    public $timestamps = false; // Si la tabla no tiene timestamps (created_at, updated_at)

    protected $fillable = [
        'NombreProyecto',
        'Descripcion',
        'Archivos',
        'Documentacion',
        'Estado',
        'IdValoraracion',
        'Fecha',
        'IdCiclo',
        'FotoProyecto',
        'IdFamilia',
        'ArchivosPriv',
        'DocumentacionPriv'
    ];

    // Relación con el modelo Ciclo
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'IdCiclo', 'IdCiclo');
    }

    // Relación con el modelo Familia
    public function familia()
    {
        return $this->belongsTo(Familia::class, 'IdFamilia', 'IdFamilia');
    }

    // Relación con el modelo Valoracion
    public function valoracion()
    {
        return $this->belongsTo(Valoracion::class, 'IdValoraracion', 'IdValoracion');
    }

    // Relación con el modelo ProyectoAlumno
    public function proyectoAlumno()
    {
        return $this->belongsTo(ProyectoAlumno::class, 'IdProyecto', 'IdProyecto');
    }
}

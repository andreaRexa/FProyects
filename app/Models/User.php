<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    // Definir la tabla asociada
    protected $table = 'usuarios';

    // Definir la clave primaria
    protected $primaryKey = 'IdUsuario';

    // Indicar si la clave primaria es autoincremental
    public $incrementing = true;

    // Definir el tipo de clave primaria
    protected $keyType = 'int';

    // Desactivar las marcas de tiempo por defecto (timestamps)
    public $timestamps = true;

    // Los atributos que se pueden asignar masivamente.
    protected $fillable = [
        'Nombre',
        'Apellidos',
        'password',
        'CodRecContr',
        'FotoUsuario',
        'FechaCreacion',
        'Correo',
        'TipoUsuario',
        'NIA'
    ];

    const CREATED_AT = 'FechaCreacion';
    const UPDATED_AT = null;

    public function alumnoCiclo()
    {
        return $this->hasOne(AlumnoCiclo::class, 'IdUsuario', 'IdUsuario');
    }

    public function familiaAlumno()
    {
        return $this->hasOne(FamiliaAlumno::class, 'IdUsuario', 'IdUsuario');
    }
    public function alumnoCurso()
    {
        return $this->hasOne(AlumnoCurso::class, 'IdUsuario', 'IdUsuario');
    }
    public function proyectoAlumno()
    {
        return $this->hasMany(ProyectoAlumno::class, 'IdUsuario', 'IdUsuario');
    }
    
}

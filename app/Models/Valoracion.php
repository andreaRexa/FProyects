<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoracion';
    protected $primaryKey = 'IdValoracion';
    public $timestamps = false; // Si la tabla no tiene timestamps (created_at, updated_at)

    protected $fillable = [
        'IdUsuario',
        'Valoracion',
    ];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario', 'IdUsuario');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
    'grupo_id',
    'usuario_id',
    'calificacion'
    ];

    // Relación con el grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    // Relación con el usuario (Alumno)
    public function alumno()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

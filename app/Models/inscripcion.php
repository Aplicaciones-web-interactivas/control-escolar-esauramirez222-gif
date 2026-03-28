<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class inscripcion extends Model
{
    use HasFactory;

    // ESTO ES LO IMPORTANTE: Laravel buscaba 'inscripcions', 
    // aquí le decimos que la tabla real es 'inscripciones'
    protected $table = 'inscripciones';

    protected $fillable = ['grupo_id', 'user_id'];

    // Relación con el usuario (Alumno)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}

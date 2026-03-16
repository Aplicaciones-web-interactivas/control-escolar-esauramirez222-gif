<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class horario extends Model
{
    use HasFactory;
    // Campos que permitimos guardar desde el formulario
    protected $fillable = ['materia_id', 'usuario_id', 'hora_inicio', 'hora_fin', 'dias'];
    // Relación: Un horario pertenece a una materia
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
    // Relación: Un horario pertenece a un maestro (usuario)
    public function maestro()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

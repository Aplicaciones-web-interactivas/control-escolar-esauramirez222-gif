<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = ['grupo_id', 'titulo', 'descripcion', 'fecha_entrega'];

    // Una tarea pertenece a un grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}

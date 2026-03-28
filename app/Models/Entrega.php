<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $fillable = ['tarea_id', 'user_id', 'archivo_ruta', 'calificacion'];

    public function tarea() {
        return $this->belongsTo(Tarea::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

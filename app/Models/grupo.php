<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grupo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'horario_id'];
    // Relación: Un grupo pertenece a un horario
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}

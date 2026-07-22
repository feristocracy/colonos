<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoNotaArchivo extends Model
{
    protected $fillable = [
        'proyecto_nota_id',
        'archivo',
        'nombre_original',
        'mime_type',
    ];

    public function nota()
    {
        return $this->belongsTo(ProyectoNota::class, 'proyecto_nota_id');
    }
}

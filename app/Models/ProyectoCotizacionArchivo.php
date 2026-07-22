<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoCotizacionArchivo extends Model
{
    protected $fillable = [
        'proyecto_cotizacion_id',
        'archivo',
        'nombre_original',
        'mime_type',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(ProyectoCotizacion::class);
    }
}

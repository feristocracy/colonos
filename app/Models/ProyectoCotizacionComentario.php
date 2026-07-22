<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoCotizacionComentario extends Model
{
    protected $fillable = [
        'proyecto_cotizacion_id',
        'user_id',
        'comentario',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(ProyectoCotizacion::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

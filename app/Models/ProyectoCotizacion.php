<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoCotizacion extends Model
{
    protected $table = 'proyecto_cotizaciones'; // O 'proyecto_cotizacion'
    
    protected $fillable = [
        'proyecto_cotizacion_concepto_id',
        'registrado_por',
        'proveedor',
        'precio',
        'observaciones',
    ];

    public function concepto()
    {
        return $this->belongsTo(ProyectoCotizacionConcepto::class, 'proyecto_cotizacion_concepto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function archivos()
    {
        return $this->hasMany(ProyectoCotizacionArchivo::class);
    }

    public function comentarios()
    {
        return $this->hasMany(ProyectoCotizacionComentario::class);
    }
}

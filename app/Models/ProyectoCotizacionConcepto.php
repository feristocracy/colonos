<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoCotizacionConcepto extends Model
{
    protected $fillable = [
        'proyecto_id',
        'creado_por',
        'nombre',
        'descripcion',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function cotizaciones()
    {
        return $this->hasMany(ProyectoCotizacion::class);
    }
}

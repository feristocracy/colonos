<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colono extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_completo',
        'direccion',
        'correo',
        'telefono',
    ];

    public function pagos(){
        return $this->hasMany(Pago::class)->orderByDesc('fecha_pago');
    }

    public function pagoPeriodos(){
        return $this->hasMany(PagoPeriodo::class)->orderByDesc('periodo');
    }

    public function getUltimoPeriodoPagadoAttribute(): ?string
    {
        return $this->pagoPeriodos()->orderByDesc('periodo')->value('periodo');
    }

    public function getEstaAlCorrienteAttribute(): bool
    {
        $ultimoPeriodo = $this->ultimo_periodo_pagado;

        if (!$ultimoPeriodo) {
            return false;
        }

        return $ultimoPeriodo >= now()->format('Y-m');
    }

    public function getStatusPagoAttribute(): string
    {
        return $this->esta_al_corriente ? 'Al corriente' : 'Con adeudo';
    }

}

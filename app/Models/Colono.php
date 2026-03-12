<?php

namespace App\Models;

use Carbon\Carbon;
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
        return $this->hasMany(Pago::class)->orderByDesc('periodo');
    }

    public function ultimoPago(){
        return $this->hasOne(Pago::class)->latestOfMany('periodo');
    }

    public function getUltimoPagoRegistradoAttribute()
    {
        return $this->pagos()->orderByDesc('periodo')->first();
    }

    public function getUltimoPeriodoPagadoAttribute(): ?string
    {
        return $this->ultimoPago?->periodo;
    }

    public function getEstaAlCorrienteAttribute(): bool
    {
        if (!$this->ultimoPago || !$this->ultimoPago->periodo) {
            return false;
        }

        $periodoActual = now()->format('Y-m');

        return $this->ultimoPago->periodo >= $periodoActual;
    }

    public function getStatusPagoAttribute(): string
    {
        return $this->esta_al_corriente ? 'Al corriente' : 'Con adeudo';
    }

}

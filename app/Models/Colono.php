<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Obtenemos el mes actual en formato YYYY-MM (ej: 2026-04)
        $mesActual = Carbon::now()->format('Y-m');

        return $this->pagoPeriodos()
            ->where('periodo', $mesActual)
            ->exists();
    }

    public function getStatusPagoAttribute(): string
    {
        return $this->esta_al_corriente ? 'Al corriente' : 'Con adeudo';
    }

    protected static function booted()
    {
        static::saving(function ($colono) {
            // Asignamos 1 o 0 a la columna física basado en la lógica del Accessor
            $colono->al_corriente = $colono->esta_al_corriente ? 1 : 0;
        });
    }

}

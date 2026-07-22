<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Proyecto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'monto_inicial',
        'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'monto_inicial' => 'decimal:2',
        ];
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function lideres(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'proyecto_lideres',
            'proyecto_id',
            'user_id'
        )->withTimestamps();
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(ProyectoMovimiento::class);
    }

    public function auditorias(): HasMany
    {
        return $this->hasMany(ProyectoAuditoria::class);
    }

    public function esLider(User $user): bool
    {
        return $this->lideres()
            ->where('users.id', $user->id)
            ->exists();
    }

    public function getSaldoActualAttribute(): float
    {
        $entradas = $this->movimientos()
            ->whereIn('tipo', ['saldo_inicial', 'entrada'])
            ->sum('monto');

        $salidas = $this->movimientos()
            ->where('tipo', 'salida')
            ->sum('monto');

        return (float) $entradas - (float) $salidas;
    }

    public function cotizacionConceptos()
    {
        return $this->hasMany(ProyectoCotizacionConcepto::class);
    }

    public function notas()
    {
        return $this->hasMany(ProyectoNota::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoFinanciero extends Model
{
    protected $table = 'movimientos_financieros';

    protected $fillable = [
        'tipo',
        'fecha',
        'monto',
        'categoria',
        'concepto',
        'comentarios',
        'comprobante_path',
        'origen',
        'pago_id',
        'created_by',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public function usuarioCreador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pago(): BelongsTo
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
}

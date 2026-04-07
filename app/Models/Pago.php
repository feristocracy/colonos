<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'colono_id',
        'folio',
        'fecha_pago',
        'monto',
        'observaciones',
        'recibo_path',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2',
    ];

    public function colono(){
        return $this->belongsTo(Colono::class);
    }

    public function periodos(){
        return $this->hasMany(PagoPeriodo::class)->orderBy('periodo');
    }
}

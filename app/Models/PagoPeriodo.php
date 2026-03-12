<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoPeriodo extends Model
{
    use HasFactory;

    protected $fillable = [
        'pago_id',
        'colono_id',
        'periodo',
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }

    public function colono()
    {
        return $this->belongsTo(Colono::class);
    }
}

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
        'al_corriente',
    ];

    protected $casts = [
        'al_corriente' => 'boolean',
    ];

}

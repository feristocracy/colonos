<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyectoAuditoria extends Model
{
    protected $fillable = [
        'proyecto_id',
        'user_id',
        'accion',
        'descripcion',
        'datos',
    ];

    protected function casts(): array
    {
        return [
            'datos' => 'array',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

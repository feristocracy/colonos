<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoNota extends Model
{
    protected $fillable = [
        'proyecto_id',
        'user_id',
        'comentario',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function archivos()
    {
        return $this->hasMany(ProyectoNotaArchivo::class);
    }
}

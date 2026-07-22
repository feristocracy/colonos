<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProyectoNotaController extends Controller
{
    public function store(Request $request, Proyecto $proyecto)
    {
        Gate::authorize('alimentar', $proyecto);

        $data = $request->validate([
            'comentario' => ['required', 'string', 'max:3000'],
            'archivos' => ['nullable', 'array'],
            'archivos.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx', 'max:10240'],
        ]);

        DB::transaction(function () use ($request, $proyecto, $data) {
            $nota = $proyecto->notas()->create([
                'user_id' => auth()->id(),
                'comentario' => $data['comentario'],
            ]);

            if ($request->hasFile('archivos')) {
                foreach ($request->file('archivos') as $archivo) {
                    $path = $archivo->store('proyectos/notas', 'public');

                    $nota->archivos()->create([
                        'archivo' => $path,
                        'nombre_original' => $archivo->getClientOriginalName(),
                        'mime_type' => $archivo->getMimeType(),
                    ]);
                }
            }

            $proyecto->auditorias()->create([
                'user_id' => auth()->id(),
                'accion' => 'nota_creada',
                'descripcion' => 'agregó una nota al proyecto',
                'datos' => [
                    'nota_id' => $nota->id,
                ],
            ]);
        });

        return back()->with('success', 'Nota agregada correctamente.');
    }
}

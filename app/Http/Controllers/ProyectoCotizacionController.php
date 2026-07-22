<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoCotizacion;
use App\Models\ProyectoCotizacionConcepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProyectoCotizacionController extends Controller
{
    public function store(Request $request, Proyecto $proyecto, ProyectoCotizacionConcepto $cotizacionConcepto)
    {
        Gate::authorize('alimentar', $proyecto);

        abort_unless($cotizacionConcepto->proyecto_id === $proyecto->id, 404);

        $data = $request->validate([
            'proveedor' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'precio' => ['required', 'numeric', 'min:0.01'],
            'observaciones' => ['nullable', 'string'],
            'archivos' => ['nullable', 'array'],
            'archivos.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        DB::transaction(function () use ($request, $proyecto, $cotizacionConcepto, $data) {
            $cotizacion = $cotizacionConcepto->cotizaciones()->create([
                'registrado_por' => auth()->id(),
                'proveedor' => $data['proveedor'],
                'telefono' => $data['telefono'] ?? null,
                'precio' => $data['precio'],
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            if ($request->hasFile('archivos')) {
                foreach ($request->file('archivos') as $archivo) {
                    $path = $archivo->store('proyectos/cotizaciones', 'public');

                    $cotizacion->archivos()->create([
                        'archivo' => $path,
                        'nombre_original' => $archivo->getClientOriginalName(),
                        'mime_type' => $archivo->getMimeType(),
                    ]);
                }
            }

            $proyecto->auditorias()->create([
                'user_id' => auth()->id(),
                'accion' => 'cotizacion_registrada',
                'descripcion' => 'registró una cotización de '.$cotizacion->proveedor.' para '.$cotizacionConcepto->nombre,
                'datos' => [
                    'cotizacion_concepto_id' => $cotizacionConcepto->id,
                    'cotizacion_id' => $cotizacion->id,
                    'precio' => $cotizacion->precio,
                ],
            ]);
        });

        return back()->with('success', 'Cotización registrada correctamente.');
    }

    public function storeArchivos(Request $request, Proyecto $proyecto, ProyectoCotizacionConcepto $cotizacionConcepto, ProyectoCotizacion $cotizacion)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        abort_unless($cotizacionConcepto->proyecto_id === $proyecto->id, 404);
        abort_unless($cotizacion->proyecto_cotizacion_concepto_id === $cotizacionConcepto->id, 404);

        $request->validate([
            'archivos' => ['required', 'array'],
            'archivos.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        foreach ($request->file('archivos') as $archivo) {
            $path = $archivo->store('proyectos/cotizaciones', 'public');

            $cotizacion->archivos()->create([
                'archivo' => $path,
                'nombre_original' => $archivo->getClientOriginalName(),
                'mime_type' => $archivo->getMimeType(),
            ]);
        }

        return back()->with('success', 'Archivos agregados correctamente.');
    }

    public function storeComentario(Request $request, Proyecto $proyecto, ProyectoCotizacionConcepto $cotizacionConcepto, ProyectoCotizacion $cotizacion)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        abort_unless($cotizacionConcepto->proyecto_id === $proyecto->id, 404);
        abort_unless($cotizacion->proyecto_cotizacion_concepto_id === $cotizacionConcepto->id, 404);

        $data = $request->validate([
            'comentario' => ['required', 'string', 'max:2000'],
        ]);

        $cotizacion->comentarios()->create([
            'user_id' => auth()->id(),
            'comentario' => $data['comentario'],
        ]);

        return back()->with('success', 'Comentario agregado correctamente.');
    }
}

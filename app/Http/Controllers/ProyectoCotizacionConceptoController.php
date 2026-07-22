<?php

namespace App\Http\Controllers;
use App\Models\Proyecto;
use App\Models\ProyectoCotizacionConcepto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProyectoCotizacionConceptoController extends Controller
{
    public function store(Request $request, Proyecto $proyecto)
    {
        Gate::authorize('alimentar', $proyecto);

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $cotizacionConcepto = $proyecto->cotizacionConceptos()->create([
            'creado_por' => auth()->id(),
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
        ]);

        $proyecto->auditorias()->create([
            'user_id' => auth()->id(),
            'accion' => 'cotizacion_concepto_creado',
            'descripcion' => 'creó el concepto de cotización: '.$cotizacionConcepto->nombre,
            'datos' => [
                'cotizacion_concepto_id' => $cotizacionConcepto->id,
            ],
        ]);

        return redirect()
            ->route('proyectos.cotizaciones.show', [$proyecto, $cotizacionConcepto])
            ->with('success', 'Concepto de cotización creado correctamente.');
    }

    public function show(Proyecto $proyecto, ProyectoCotizacionConcepto $cotizacionConcepto)
    {
        Gate::authorize('view', $proyecto);

        abort_unless($cotizacionConcepto->proyecto_id === $proyecto->id, 404);

        $cotizacionConcepto->load('creador');

        $cotizaciones = $cotizacionConcepto->cotizaciones()
            ->with(['usuario', 'archivos', 'comentarios.usuario'])
            ->latest()
            ->paginate(10);

        return view('proyectos.cotizaciones.show', compact(
            'proyecto',
            'cotizacionConcepto',
            'cotizaciones'
        ));
    }
}

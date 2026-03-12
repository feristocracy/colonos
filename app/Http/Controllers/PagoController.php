<?php

namespace App\Http\Controllers;

use App\Models\Colono;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function store(Request $request, Colono $colono)
    {
        if (!auth()->user()->isTesorero()) {
            abort(403, 'Solo el tesorero puede registrar pagos.');
        }

        $validated = $request->validate([
            'periodos' => ['required', 'array', 'min:1'],
            'periodos.*' => ['required', 'date_format:Y-m'],
            'fecha_pago' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'observaciones' => ['nullable', 'string', 'max:500'],
            'recibo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
                'periodos.required' => 'Debe seleccionar al menos un mes.',
                'periodos.array' => 'Los meses seleccionados no son válidos.',
                'periodos.min' => 'Debes seleccionar al menos un mes',
                'periodos.*.date_format' => 'Uno de los meses seleccionados no tiene formato',
                'fecha_pago.required' => 'La fecha de pago es obligatoria.',
                'monto.required' => 'El monto es obligatorio.',
                'monto.numeric' => 'El monto debe ser numérico.',
                'monto.min' => 'El monto debe ser mayor a cero.',
                'recibo.image' => 'El archivo debe ser una imagen.',
                'recibo.mimes' => 'El recibo debe ser jpg, jpeg, png o webp.',
                'recibo.max' => 'La imagen no debe pesar más de 4 MB.',
            ]);

        $periodos = array_unique($validated['periodos']);

        $periodosDuplicados = $colono->pagoPeriodos()
            ->whereIn('periodo', $periodos)
            ->pluck('periodo')
            ->toArray();

        if (!empty($periodosDuplicados)) {
            return back()
                ->withErrors([
                    'periodos' => 'Uno o más meses seleccionados ya fueron pagados: ' . implode(', ', $periodosDuplicados),
                ])
                ->withInput();
        }

        $reciboPath = null;

        if ($request->hasFile('recibo')) {
            $reciboPath = $request->file('recibo')->store('recibos-pagos', 'public');
        }

        DB::transaction(function () use ($colono, $validated, $periodos, $reciboPath) {
            $pago = $colono->pagos()->create([
                'fecha_pago' => $validated['fecha_pago'],
                'monto' => $validated['monto'],
                'observaciones' => $validated['observaciones'] ?? null,
                'recibo_path' => $reciboPath,
            ]);

            foreach ($periodos as $periodo) {
                $pago->periodos()->create([
                    'colono_id' => $colono->id,
                    'periodo' => $periodo,
                ]);
            }
        });

        return redirect()
            ->route('colonos.show', $colono)
            ->with('success', 'Pago registrado correctamente.');
    }
}

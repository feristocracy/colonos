<?php

namespace App\Http\Controllers;

use App\Models\Colono;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PagoController extends Controller
{
    public function store(Request $request, Colono $colono)
    {
        if (!auth()->user()->isTesorero()) {
            abort(403, 'Solo el tesorero puede registrar pagos.');
        }

        $validated = $request->validate([
            'periodo' => [
                'required',
                'date_format:Y-m',
                Rule::unique('pagos', 'periodo')->where(function ($query) use ($colono) {
                    return $query->where('colono_id', $colono->id);
                }),
            ],
            'fecha_pago' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'concepto' => ['nullable', 'string', 'max:255'],
            'recibo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
                'periodo.required' => 'El mes correspondiente es obligatorio.',
                'periodo.date_format' => 'El periodo debe tener formato válido.',
                'periodo.unique' => 'Ese mes ya fue registrado para este colono.',
                'fecha_pago.required' => 'La fecha de pago es obligatoria.',
                'monto.required' => 'El monto es obligatorio.',
                'monto.numeric' => 'El monto debe ser numérico.',
                'monto.min' => 'El monto debe ser mayor a cero.',
                'recibo.image' => 'El archivo debe ser una imagen.',
                'recibo.mimes' => 'El recibo debe ser jpg, jpeg, png o webp.',
                'recibo.max' => 'La imagen no debe pesar más de 4 MB.',
            ]);

        $reciboPath = null;

        if ($request->hasFile('recibo')) {
            $reciboPath = $request->file('recibo')->store('recibos-pagos', 'public');
        }

        $colono->pagos()->create([
            'periodo' => $validated['periodo'],
            'fecha_pago' => $validated['fecha_pago'],
            'monto' => $validated['monto'],
            'concepto' => $validated['concepto'] ?? null,
            'recibo_path' => $reciboPath,
        ]);

        return redirect()
            ->route('colonos.show', $colono)
            ->with('success', 'Pago registrado correctamente.');
    }
}

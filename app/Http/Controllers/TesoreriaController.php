<?php

namespace App\Http\Controllers;

use App\Models\MovimientoFinanciero;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TesoreriaController extends Controller
{
    public function index(Request $request)
    {
        $mes = (int) ($request->mes ?? now()->month);
        $anio = (int) ($request->anio ?? now()->year);
        $tipo = $request->tipo;

        $query = MovimientoFinanciero::query()
            ->when($mes, fn ($q) => $q->whereMonth('fecha', $mes))
            ->when($anio, fn ($q) => $q->whereYear('fecha', $anio))
            ->when(in_array($tipo, ['ingreso', 'egreso']), fn ($q) => $q->where('tipo', $tipo))
            ->orderByDesc('fecha')
            ->orderByDesc('id');

        $movimientos = $query->paginate(15)->withQueryString();

        $ingresosMes = MovimientoFinanciero::query()
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->where('tipo', 'ingreso')
            ->sum('monto');

        $egresosMes = MovimientoFinanciero::query()
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->where('tipo', 'egreso')
            ->sum('monto');

        $saldoActual = 
            MovimientoFinanciero::where('tipo', 'ingreso')->sum('monto')
            - MovimientoFinanciero::where('tipo', 'egreso')->sum('monto');

        $balanceMes = $ingresosMes - $egresosMes;

        return view('tesoreria.index', compact(
            'movimientos',
            'mes',
            'anio',
            'tipo',
            'ingresosMes',
            'egresosMes',
            'saldoActual',
            'balanceMes'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => ['required', 'in:ingreso,egreso'],
            'fecha' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'categoria' => ['nullable', 'string', 'max:255'],
            'concepto' => ['required', 'string', 'max:255'],
            'comentarios' => ['nullable', 'string'],
            'comprobante' => ['nullable', 'image', 'max:4096'],
        ]);

        $path = null;

        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('tesoreria/comprobantes', 'public');
        }

        MovimientoFinanciero::create([
            'tipo' => $validated['tipo'],
            'fecha' => $validated['fecha'],
            'monto' => $validated['monto'],
            'categoria' => $validated['categoria'] ?? null,
            'concepto' => $validated['concepto'],
            'comentarios' => $validated['comentarios'] ?? null,
            'comprobante_path' => $path,
            'origen' => 'manual',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('tesoreria.index', [
                'mes' => Carbon::parse($validated['fecha'])->month,
                'anio' => Carbon::parse($validated['fecha'])->year,
            ])
            ->with('success', 'Movimiento financiero registrado correctamente.');
    }

    public function print(Request $request)
{
    $mes = (int) ($request->mes ?? now()->month);
    $anio = (int) ($request->anio ?? now()->year);

    $movimientos = MovimientoFinanciero::query()
        ->whereMonth('fecha', $mes)
        ->whereYear('fecha', $anio)
        ->orderBy('fecha')
        ->orderBy('id')
        ->get();

    $ingresosMes = $movimientos->where('tipo', 'ingreso')->sum('monto');
    $egresosMes = $movimientos->where('tipo', 'egreso')->sum('monto');
    $balanceMes = $ingresosMes - $egresosMes;

    return view('tesoreria.print', compact(
        'movimientos',
        'mes',
        'anio',
        'ingresosMes',
        'egresosMes',
        'balanceMes'
    ));
}
}

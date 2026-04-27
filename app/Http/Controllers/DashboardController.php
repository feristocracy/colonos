<?php

namespace App\Http\Controllers;
use App\Models\Colono;
use App\Models\MovimientoFinanciero;
use Carbon\Carbon;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $mes = (int) ($request->mes ?? now()->month);
        $anio = (int) ($request->anio ?? now()->year);
        $tipo = $request->tipo ?? 'ingreso';

        $periodoActual = Carbon::now()->format('Y-m');

        $totalColonos = Colono::count();

        $colonosAlCorriente = Colono::whereHas('pagoPeriodos', function ($query) use ($periodoActual) {
            $query->where('periodo', $periodoActual);
        })->count();

        $colonosConAdeudo = Colono::whereDoesntHave('pagoPeriodos', function ($query) use ($periodoActual) {
            $query->where('periodo', $periodoActual);
        })->count();    


        // Aquí podrías consultar datos, por ejemplo:
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


            
        return view('dashboard', compact('totalColonos', 'ingresosMes', 'egresosMes', 'colonosConAdeudo', 'colonosAlCorriente'));
    }
}
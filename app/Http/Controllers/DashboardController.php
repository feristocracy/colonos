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

        //grafico de barras
        $year = now()->year;

        $movimientos = MovimientoFinanciero::query()
            ->selectRaw('MONTH(fecha) as mes')
            ->selectRaw("SUM(CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END) as ingresos")
            ->selectRaw("SUM(CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END) as egresos")
            ->whereYear('fecha', $year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $ingresosPorMes = [];
        $egresosPorMes = [];

        for ($i = 1; $i <= 12; $i++) {
            $registro = $movimientos->firstWhere('mes', $i);

            $ingresosPorMes[] = $registro ? (float) $registro->ingresos : 0;
            $egresosPorMes[] = $registro ? (float) $registro->egresos : 0;
        }



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


            
        return view('dashboard', compact('totalColonos', 'ingresosMes', 'egresosMes', 'colonosConAdeudo', 'colonosAlCorriente', 'ingresosPorMes', 'egresosPorMes', 'year'));
    }
}
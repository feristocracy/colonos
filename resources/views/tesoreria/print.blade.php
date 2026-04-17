<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado Financiero - {{ ucfirst(\Carbon\Carbon::create()->month($mes)->locale('es')->monthName) }} {{ $anio }}</title>
    <!-- Se incluye Tailwind CSS vía CDN para usar sus utilidades rápidamente -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }

        .print-container {
            max-w: 210mm; /* A4 width aprox */
            margin: 2rem auto;
            background: white;
            padding: 2.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 0.5rem;
        }

        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }
            .print-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
                max-w: 100%;
                border-radius: 0;
            }
            .no-print {
                display: none !important;
            }
            /* Asegurar que los fondos se impriman si el navegador lo permite */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="antialiased text-gray-800">

    <!-- Barra de acciones flotante (no se imprime) -->
    <div class="no-print fixed top-0 left-0 right-0 bg-white border-b border-gray-200 shadow-sm z-50 px-6 py-4 flex justify-between items-center">
        <div class="text-sm text-gray-500 font-medium">
            Vista previa de impresión
        </div>
        <button onclick="window.print()" class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-900 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-all shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Imprimir Documento
        </button>
    </div>

    <!-- Espaciador para la barra fija -->
    <div class="h-20 no-print"></div>

    <!-- Contenedor principal estilo hoja A4 -->
    <div class="print-container">
        
        <!-- Cabecera del Documento -->
        <div class="border-b-2 border-gray-800 pb-6 mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight uppercase">Estado Financiero</h1>
                <p class="text-lg text-gray-500 mt-1 font-medium">Tesorería de Colonos</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold">Periodo Reportado</p>
                <p class="text-xl font-bold text-gray-800">{{ ucfirst(\Carbon\Carbon::create()->month($mes)->locale('es')->monthName) }} {{ $anio }}</p>
            </div>
        </div>

        <!-- Resumen Financiero -->
        <div class="grid grid-cols-3 gap-4 mb-10">
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Total Ingresos</p>
                <p class="text-2xl font-bold text-green-600">${{ number_format($ingresosMes, 2) }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Total Egresos</p>
                <p class="text-2xl font-bold text-red-600">${{ number_format($egresosMes, 2) }}</p>
            </div>
            <div class="bg-gray-100 rounded-lg p-4 border border-gray-300 shadow-inner">
                <p class="text-xs text-gray-600 uppercase tracking-wider font-bold mb-1">Balance del Mes</p>
                <p class="text-2xl font-extrabold {{ $balanceMes >= 0 ? 'text-green-700' : 'text-red-700' }}">
                    ${{ number_format($balanceMes, 2) }}
                </p>
            </div>
        </div>

        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Detalle de Movimientos</h2>

        <!-- Tabla de Movimientos -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="py-3 px-2 border-b-2 border-gray-300 bg-gray-50 text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha</th>
                    <th class="py-3 px-2 border-b-2 border-gray-300 bg-gray-50 text-xs font-bold text-gray-600 uppercase tracking-wider">Tipo</th>
                    <th class="py-3 px-2 border-b-2 border-gray-300 bg-gray-50 text-xs font-bold text-gray-600 uppercase tracking-wider">Concepto</th>
                    <th class="py-3 px-2 border-b-2 border-gray-300 bg-gray-50 text-xs font-bold text-gray-600 uppercase tracking-wider text-right">Monto</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200">
                @forelse($movimientos as $movimiento)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-2 text-gray-600 font-medium w-24">{{ $movimiento->fecha->format('d/m/Y') }}</td>
                        <td class="py-3 px-2 w-24">
                            <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-md {{ $movimiento->tipo === 'ingreso' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($movimiento->tipo) }}
                            </span>
                        </td>
                        <td class="py-3 px-2">
                            <div class="font-bold text-gray-800">{{ $movimiento->concepto }}</div>
                            @if($movimiento->comentarios)
                                <div class="text-xs text-gray-500 mt-0.5">{{ $movimiento->comentarios }}</div>
                            @endif
                        </td>
                        <td class="py-3 px-2 text-right font-bold {{ $movimiento->tipo === 'ingreso' ? 'text-green-600' : 'text-red-600' }} w-32">
                            {{ $movimiento->tipo === 'ingreso' ? '+' : '-' }}${{ number_format($movimiento->monto, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500 italic border-b border-gray-200">
                            No se registraron movimientos en este periodo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="py-4 px-2 text-right font-bold text-gray-600 uppercase text-xs">Balance Final:</td>
                    <td class="py-4 px-2 text-right font-extrabold text-base border-t-2 border-gray-800 {{ $balanceMes >= 0 ? 'text-green-700' : 'text-red-700' }}">
                        ${{ number_format($balanceMes, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Pie de página de impresión -->
        <div class="mt-16 pt-8 border-t border-gray-200 text-center text-xs text-gray-400 flex justify-between items-center">
            <p>Documento generado el {{ now()->format('d/m/Y H:i') }}</p>
            <p>Página 1 de 1</p>
        </div>

    </div>

</body>
</html>

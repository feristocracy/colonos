<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-violet-900 leading-tight">
            Histórico Financiero
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Encabezado -->
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-violet-900 tracking-tight">Bitácora de Movimientos</h1>
                    <p class="mt-2 text-sm text-violet-600/80">
                        Registro detallado de todas las transacciones y acciones realizadas en el sistema.
                    </p>
                </div>

                <div class="flex">
                    <a href="{{ route('tesoreria.index') }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-700 hover:bg-violet-50 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all shadow-sm">
                        <svg class="w-5 h-5 mr-2 -ml-1 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Volver a Tesorería
                    </a>
                </div>
            </div>

            <!-- Tabla del Histórico -->
            <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-2xl border border-violet-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-100">
                        <thead class="bg-violet-50/80">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Fecha Registro</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Acción</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Fecha Mov.</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Concepto</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Origen</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Referencia</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-violet-800 uppercase tracking-wider whitespace-nowrap">Monto</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-violet-50 bg-white">
                            @forelse($movimientos as $movimiento)
                                @php
                                    $accion = '';

                                    if ($movimiento->origen === 'pago_colono') {
                                        $accion = 'Pago de cuota registrado';
                                    } elseif ($movimiento->origen === 'manual' && $movimiento->tipo === 'ingreso') {
                                        $accion = 'Ingreso manual registrado';
                                    } elseif ($movimiento->origen === 'manual' && $movimiento->tipo === 'egreso') {
                                        $accion = 'Egreso manual registrado';
                                    } else {
                                        $accion = 'Movimiento registrado';
                                    }

                                    $referencia = '—';

                                    if ($movimiento->origen === 'pago_colono' && $movimiento->pago) {
                                        $referencia = $movimiento->pago->folio ?? ('Pago #' . $movimiento->pago->id);
                                    } else {
                                        $referencia = 'Movimiento #' . $movimiento->id;
                                    }
                                @endphp

                                <tr class="hover:bg-violet-50/60 transition-colors group">
                                    <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-600 font-medium">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $movimiento->created_at?->format('d/m/Y') ?? '—' }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-500">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $movimiento->created_at?->format('H:i:s') ?? '—' }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap text-xs font-semibold text-violet-700">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-violet-100 flex items-center justify-center text-xs text-violet-600 border border-violet-200">
                                                {{ strtoupper(substr($movimiento->usuarioCreador->name ?? 'S', 0, 1)) }}
                                            </div>
                                            {{ $movimiento->usuarioCreador->name ?? 'Sistema' }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-700">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-50 border border-gray-200 text-xs font-medium text-gray-600">
                                            {{ $accion }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-600 text-center">
                                        {{ $movimiento->fecha?->format('d/m/Y') ?? '—' }}
                                    </td>

                                    <td class="px-4 py-2 text-xs text-gray-700 min-w-[200px]">
                                        <div class="font-bold text-violet-900">{{ $movimiento->concepto }}</div>
                                        @if($movimiento->comentarios)
                                            <div class="text-xs text-violet-500/80 mt-1 line-clamp-2" title="{{ $movimiento->comentarios }}">
                                                {{ $movimiento->comentarios }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap text-xs text-center">
                                        @if($movimiento->origen === 'pago_colono')
                                            <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 border border-indigo-100 shadow-sm">
                                                Pago Colono
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-gray-50 px-3 py-1 text-xs font-bold text-gray-600 border border-gray-200 shadow-sm">
                                                Manual
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap text-xs">
                                        <span class="font-mono text-xs font-semibold text-violet-800 bg-violet-50 px-2 py-1 rounded border border-violet-100">
                                            {{ $referencia }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap text-xs text-right font-extrabold {{ $movimiento->tipo === 'ingreso' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $movimiento->tipo === 'ingreso' ? '+' : '-' }} ${{ number_format($movimiento->monto, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-16 w-16 bg-violet-100 text-violet-500 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-violet-900 mb-1">Sin Registros</h3>
                                            <p class="text-sm text-violet-600">No hay movimientos registrados en la bitácora todavía.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($movimientos->hasPages())
                    <div class="border-t border-violet-100 px-6 py-4 bg-gray-50/50">
                        {{ $movimientos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-violet-900 leading-tight">
            Tesorería
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Encabezado -->
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-violet-900 tracking-tight">Tesorería</h1>
                    <p class="mt-2 text-sm text-violet-600/80">
                        Estado financiero y control de ingresos/egresos de la asociación.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('tesoreria.historico') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-700 hover:bg-violet-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all shadow-sm">
                        <svg class="w-5 h-5 mr-2 -ml-1 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Histórico
                    </a>
                    <a href="{{ route('tesoreria.print', ['mes' => $mes, 'anio' => $anio]) }}"
                       target="_blank"
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Imprimir Mes
                    </a>
                </div>
            </div>

            <!-- Alertas -->
            @if(session('success'))
                <div class="mb-8 rounded-xl border border-emerald-200 bg-emerald-50 p-4 flex items-center shadow-sm">
                    <svg class="h-5 w-5 text-emerald-400 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Tarjetas de Resumen -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- Saldo Actual -->
                <div class="rounded-2xl bg-white shadow-xl shadow-violet-100/50 border border-violet-100 p-6 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-violet-50 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-semibold text-violet-600 uppercase tracking-wider">Saldo en Caja</p>
                            <div class="p-2 bg-violet-100 rounded-lg text-violet-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold text-violet-900">${{ number_format($saldoActual, 2) }}</p>
                    </div>
                </div>

                <!-- Ingresos -->
                <div class="rounded-2xl bg-white shadow-xl shadow-emerald-100/50 border border-emerald-100 p-6 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wider">Ingresos del Mes</p>
                            <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold text-emerald-600">${{ number_format($ingresosMes, 2) }}</p>
                    </div>
                </div>

                <!-- Egresos -->
                <div class="rounded-2xl bg-white shadow-xl shadow-rose-100/50 border border-rose-100 p-6 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-semibold text-rose-600 uppercase tracking-wider">Egresos del Mes</p>
                            <div class="p-2 bg-rose-100 rounded-lg text-rose-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold text-rose-600">${{ number_format($egresosMes, 2) }}</p>
                    </div>
                </div>

                <!-- Balance -->
                <div class="rounded-2xl bg-white shadow-xl {{ $balanceMes >= 0 ? 'shadow-emerald-100/50 border-emerald-100' : 'shadow-rose-100/50 border-rose-100' }} border p-6 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 {{ $balanceMes >= 0 ? 'bg-emerald-50' : 'bg-rose-50' }} rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-semibold {{ $balanceMes >= 0 ? 'text-emerald-600' : 'text-rose-600' }} uppercase tracking-wider">Balance del Mes</p>
                            <div class="p-2 {{ $balanceMes >= 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }} rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold {{ $balanceMes >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            ${{ number_format($balanceMes, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Filtros de Búsqueda -->
            <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-2xl border border-violet-100 overflow-hidden mb-8 p-6">
                <form method="GET" action="{{ route('tesoreria.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-5 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-violet-900 mb-1.5">Mes</label>
                        <select name="mes" class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all">
                            @foreach(range(1, 12) as $numeroMes)
                                <option value="{{ $numeroMes }}" {{ (int)$mes === $numeroMes ? 'selected' : '' }}>
                                    {{ ucfirst(\Carbon\Carbon::create()->month($numeroMes)->locale('es')->monthName) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-violet-900 mb-1.5">Año</label>
                        <select name="anio" class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all">
                            @foreach(range(now()->year - 5, now()->year + 1) as $year)
                                <option value="{{ $year }}" {{ (int)$anio === $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-violet-900 mb-1.5">Tipo</label>
                        <select name="tipo" class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all">
                            <option value="">Todos</option>
                            <option value="ingreso" {{ $tipo === 'ingreso' ? 'selected' : '' }}>Ingresos</option>
                            <option value="egreso" {{ $tipo === 'egreso' ? 'selected' : '' }}>Egresos</option>
                        </select>
                    </div>

                    <div class="flex">
                        <button class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-violet-100 border border-transparent rounded-xl font-semibold text-sm text-violet-800 hover:bg-violet-200 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all">
                            Filtrar Resultados
                        </button>
                    </div>
                </form>
            </div>

            <!-- Formulario Nuevo Movimiento -->
            @if(auth()->user()->role === 'tesorero')
                <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-2xl border border-violet-100 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-violet-50 to-white px-6 py-5 border-b border-violet-100 flex items-center gap-3">
                        <div class="h-10 w-10 bg-violet-100 rounded-full flex items-center justify-center text-violet-600 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-violet-900">Registrar Movimiento Manual</h2>
                            <p class="text-xs text-violet-500 font-medium mt-0.5">Captura un nuevo ingreso o egreso.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('tesoreria.store') }}" enctype="multipart/form-data" class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 items-start">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-violet-900 mb-1.5">Tipo <span class="text-rose-500">*</span></label>
                            <select name="tipo" class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all" required>
                                <option value="">Seleccione</option>
                                <option value="ingreso">Ingreso</option>
                                <option value="egreso">Egreso</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-violet-900 mb-1.5">Fecha <span class="text-rose-500">*</span></label>
                            <input type="date" name="fecha" value="{{ now()->format('Y-m-d') }}" class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-violet-900 mb-1.5">Monto <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-violet-500 font-bold sm:text-sm">$</span>
                                </div>
                                <input type="number" name="monto" step="0.01" min="0.01" placeholder="0.00" class="block w-full rounded-xl border-violet-200 bg-white pl-8 pr-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-violet-900 mb-1.5">Concepto <span class="text-rose-500">*</span></label>
                            <input type="text" name="concepto" placeholder="Ej. Pago de jardinería" class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-violet-900 mb-1.5">Comentarios</label>
                            <textarea name="comentarios" rows="2" placeholder="Detalles adicionales..." class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all custom-scrollbar"></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-violet-900 mb-1.5">Comprobante</label>
                            <input type="file" name="comprobante" accept=".jpg,.jpeg,.png,.webp,image/*" class="block w-full text-sm text-violet-700 border border-violet-200 rounded-xl shadow-sm bg-white file:mr-4 file:py-2.5 file:px-4 file:border-0 file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 transition-all focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 cursor-pointer">
                        </div>

                        <div class="md:col-span-2 lg:col-span-4 flex justify-end mt-2 pt-5 border-t border-violet-50">
                            <button class="inline-flex items-center justify-center px-6 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Guardar Movimiento
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Tabla de Movimientos -->
            <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-2xl border border-violet-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-100">
                        <thead class="bg-violet-50/80">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-bold text-violet-800 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-violet-800 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Concepto</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-violet-800 uppercase tracking-wider">Origen</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-violet-800 uppercase tracking-wider">Monto</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-violet-800 uppercase tracking-wider">Comprobante</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-violet-50 bg-white">
                            @forelse($movimientos as $movimiento)
                                <tr class="hover:bg-violet-50/60 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center font-medium">
                                        {{ $movimiento->fecha->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $movimiento->tipo === 'ingreso' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }} shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $movimiento->tipo === 'ingreso' ? 'bg-emerald-500' : 'bg-rose-500' }} mr-1.5"></span>
                                            {{ ucfirst($movimiento->tipo) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <div class="font-bold text-violet-900">{{ $movimiento->concepto }}</div>
                                        @if($movimiento->comentarios)
                                            <div class="text-violet-500 text-xs mt-1">{{ $movimiento->comentarios }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        @if($movimiento->origen === 'pago_colono')
                                            <span class="inline-flex items-center rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 border border-indigo-100">
                                                Pago Colono
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2.5 py-1 text-xs font-semibold text-gray-600 border border-gray-200">
                                                Manual
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-extrabold {{ $movimiento->tipo === 'ingreso' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $movimiento->tipo === 'ingreso' ? '+' : '-' }} ${{ number_format($movimiento->monto, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($movimiento->comprobante_path || ($movimiento->origen === 'pago_colono' && $movimiento->pago && $movimiento->pago->recibo_path))
                                            @php
                                                $path = $movimiento->comprobante_path ?: $movimiento->pago->recibo_path;
                                            @endphp
                                            <div class="relative group/tooltip inline-block">
                                                <a href="{{ asset('storage/' . $path) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-violet-50 text-violet-600 hover:bg-violet-100 hover:text-violet-800 transition-colors border border-violet-200 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                </a>
                                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 scale-95 group-hover/tooltip:opacity-100 group-hover/tooltip:scale-100 transition-all duration-200 ease-out bg-gray-900 text-white text-xs rounded-lg px-3 py-1.5 whitespace-nowrap shadow-xl z-50 pointer-events-none">
                                                    Ver comprobante
                                                </div>
                                            </div>
                                        @else
                                            <div class="relative group/tooltip inline-block">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 border border-gray-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                </span>
                                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 scale-95 group-hover/tooltip:opacity-100 group-hover/tooltip:scale-100 transition-all duration-200 ease-out bg-gray-900 text-white text-xs rounded-lg px-3 py-1.5 whitespace-nowrap shadow-xl z-50 pointer-events-none">
                                                    Sin comprobante
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-16 w-16 bg-violet-100 text-violet-500 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-violet-900 mb-1">Sin Movimientos</h3>
                                            <p class="text-sm text-violet-600">No hay movimientos registrados para este periodo o filtros.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($movimientos->hasPages())
                    <div class="px-6 py-4 border-t border-violet-100 bg-gray-50/50">
                        {{ $movimientos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <style>
        /* Estilos para el scroll en textareas si fuera necesario */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #ddd6fe; border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #c4b5fd; }
    </style>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-violet-900 leading-tight">
            Gestión de Pagos
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen" x-data="{ openObs: false, obsText: '' }" @keydown.escape.window="openObs = false">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-violet-900 tracking-tight">Historial General de Pagos</h1>
                <p class="mt-2 text-sm text-violet-600/80">Consulta y filtra los pagos registrados por todos los colonos.</p>
            </div>

            <!-- Filtros -->
            <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-2xl border border-violet-100 overflow-hidden mb-8 p-6">
                <form method="GET" action="{{ route('pagos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-5 items-end">
                    <div>
                        <label for="folio" class="block text-sm font-semibold text-violet-900 mb-1.5">Buscar por folio</label>
                        <input
                            type="text"
                            name="folio"
                            id="folio"
                            value="{{ request('folio') }}"
                            placeholder="Ej. REC-2026-0012"
                            class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                        >
                    </div>

                    <div>
                        <label for="mes" class="block text-sm font-semibold text-violet-900 mb-1.5">Mes</label>
                        <select
                            name="mes"
                            id="mes"
                            class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                        >
                            <option value="">Todos</option>
                            @foreach([
                                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                            ] as $numero => $nombre)
                                <option value="{{ $numero }}" {{ request('mes') == $numero ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="anio" class="block text-sm font-semibold text-violet-900 mb-1.5">Año</label>
                        <select
                            name="anio"
                            id="anio"
                            class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                        >
                            <option value="">Todos</option>
                            @foreach($anios as $anio)
                                <option value="{{ $anio }}" {{ request('anio') == $anio ? 'selected' : '' }}>
                                    {{ $anio }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="flex-1 inline-flex items-center justify-center px-5 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all"
                        >
                            Filtrar
                        </button>

                        <a
                            href="{{ route('pagos.index') }}"
                            class="flex-1 inline-flex items-center justify-center px-5 py-2.5 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-700 hover:bg-violet-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all"
                        >
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabla de Pagos -->
            <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-2xl border border-violet-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-100">
                        <thead class="bg-violet-50/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Folio</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Colono</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Periodo Pagado</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Fecha de pago</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Monto</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-violet-800 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-violet-50 bg-white">
                            @forelse($pagos as $pago)
                                <tr class="hover:bg-violet-50/60 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-violet-900">
                                        {{ $pago->folio }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <a href="{{ route('colonos.show', $pago->colono) }}" class="font-medium text-violet-600 hover:text-violet-800 transition-colors underline decoration-violet-200 hover:decoration-violet-500">
                                            {{ $pago->colono->nombre_completo ?? 'Sin colono' }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        @if($pago->periodos->count())
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($pago->periodos as $periodo)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-violet-100 text-violet-800 border border-violet-200">
                                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $periodo->periodo)->translatedFormat('M Y') }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Sin periodos</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }} 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-emerald-600">
                                        ${{ number_format($pago->monto, 2) }} 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm flex items-center justify-center gap-3">
                                        <!-- Acción: Ver recibo -->
                                        @if($pago->recibo_path)
                                            <div class="relative group/tooltip">
                                                <a href="{{ asset('storage/' . $pago->recibo_path) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-violet-50 text-violet-600 hover:bg-violet-100 hover:text-violet-800 transition-colors border border-violet-200 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                </a>
                                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 scale-95 group-hover/tooltip:opacity-100 group-hover/tooltip:scale-100 transition-all duration-200 ease-out bg-gray-900 text-white text-xs rounded-lg px-3 py-1.5 whitespace-nowrap shadow-xl z-50 pointer-events-none">
                                                    Ver recibo
                                                </div>
                                            </div>
                                        @else
                                            <div class="relative group/tooltip">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 border border-gray-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                </span>
                                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 scale-95 group-hover/tooltip:opacity-100 group-hover/tooltip:scale-100 transition-all duration-200 ease-out bg-gray-900 text-white text-xs rounded-lg px-3 py-1.5 whitespace-nowrap shadow-xl z-50 pointer-events-none">
                                                    Sin recibo
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Acción: Ver observaciones -->
                                        @if($pago->observaciones)
                                            <div class="relative group/tooltip">
                                                <button type="button" @click.prevent="obsText = `{{ addslashes($pago->observaciones) }}`; openObs = true" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-violet-50 text-violet-600 hover:bg-violet-100 hover:text-violet-800 transition-colors border border-violet-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                </button>
                                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 scale-95 group-hover/tooltip:opacity-100 group-hover/tooltip:scale-100 transition-all duration-200 ease-out bg-gray-900 text-white text-xs rounded-lg px-3 py-1.5 whitespace-nowrap shadow-xl z-50 pointer-events-none">
                                                    Ver observaciones
                                                </div>
                                            </div>
                                        @else
                                            <div class="relative group/tooltip">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 border border-gray-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                </span>
                                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 scale-95 group-hover/tooltip:opacity-100 group-hover/tooltip:scale-100 transition-all duration-200 ease-out bg-gray-900 text-white text-xs rounded-lg px-3 py-1.5 whitespace-nowrap shadow-xl z-50 pointer-events-none">
                                                    Sin observaciones
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
                                            <h3 class="text-lg font-bold text-violet-900 mb-1">No se encontraron pagos</h3>
                                            <p class="text-sm text-violet-600">No hay registros que coincidan con los filtros seleccionados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pagos->hasPages())
                    <div class="px-6 py-4 border-t border-violet-100 bg-gray-50/50">
                        {{ $pagos->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal de Observaciones (AlpineJS) -->
        <div x-show="openObs" x-transition.opacity.duration.300ms class="fixed inset-0 bg-violet-900/40 backdrop-blur-sm z-40" style="display: none;" @click="openObs = false"></div>

        <div x-show="openObs"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center px-4 pt-4 pb-20 sm:p-0"
            style="display: none;"
        >
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all" @click.stop>
                <div class="bg-gradient-to-r from-violet-50 to-white px-6 py-5 border-b border-violet-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-violet-100 rounded-full flex items-center justify-center text-violet-600 shadow-inner">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-violet-900">Observaciones del Pago</h3>
                    </div>
                    <button type="button" @click="openObs = false" class="text-violet-400 hover:text-violet-700 hover:bg-violet-50 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="px-6 py-8">
                    <p x-text="obsText" class="text-gray-700 whitespace-pre-line text-sm bg-violet-50/50 p-4 rounded-xl border border-violet-100"></p>
                </div>

                <div class="flex justify-end border-t border-violet-50 px-6 py-4 bg-gray-50/50">
                    <button type="button" @click="openObs = false" class="inline-flex items-center justify-center px-6 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

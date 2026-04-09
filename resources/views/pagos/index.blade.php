<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Pagos
        </h2>
    </x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Pagos</h1>
        <p class="text-sm text-gray-500 mt-1">
            Historial general de pagos registrados por todos los colonos.
        </p>
    </div>

    <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-2xl p-6 mb-6">
        <form method="GET" action="{{ route('pagos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="folio" class="block text-sm font-medium text-gray-700 mb-1">Buscar por folio</label>
                <input
                    type="text"
                    name="folio"
                    id="folio"
                    value="{{ request('folio') }}"
                    placeholder="Ej. REC-2026-0012"
                    class="w-full rounded-xl border-gray-300 focus:border-violet-500 focus:ring-violet-500"
                >
            </div>

            <div>
                <label for="mes" class="block text-sm font-medium text-gray-700 mb-1">Mes</label>
                <select
                    name="mes"
                    id="mes"
                    class="w-full rounded-xl border-gray-300 focus:border-violet-500 focus:ring-violet-500"
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
                <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <select
                    name="anio"
                    id="anio"
                    class="w-full rounded-xl border-gray-300 focus:border-violet-500 focus:ring-violet-500"
                >
                    <option value="">Todos</option>
                    @foreach($anios as $anio)
                        <option value="{{ $anio }}" {{ request('anio') == $anio ? 'selected' : '' }}>
                            {{ $anio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-violet-600 px-4 py-2 text-white font-medium hover:bg-violet-700 transition"
                >
                    Filtrar
                </button>

                <a
                    href="{{ route('pagos.index') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-2 text-gray-700 font-medium hover:bg-gray-200 transition"
                >
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Folio
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Colono
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Periodo Pagado
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Fecha de pago
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Monto
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Recibo
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagos as $pago)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $pago->folio }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <a href="{{ route('colonos.show', $pago->colono) }}">{{ $pago->colono->nombre_completo ?? 'Sin colono' }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @foreach($pago->periodos as $periodo)
                                    <span>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $periodo->periodo)->translatedFormat('F Y') }}
                                    </span>
                                    @if (!$loop->last)
                                    ,  
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }} 
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $pago->monto }} 
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($pago->recibo_path)
                                    <a
                                        href="{{ asset('storage/' . $pago->recibo_path) }}"
                                        target="_blank"
                                        class="text-violet-600 hover:text-violet-800 font-medium underline"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm40-80h480L570-480 450-320l-90-120-120 160Zm-40 80v-560 560Z"/></svg>
                                    </a>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#999999"><path d="m840-234-80-80v-446H314l-80-80h526q33 0 56.5 23.5T840-760v526ZM792-56l-64-64H200q-33 0-56.5-23.5T120-200v-528l-64-64 56-56 736 736-56 56ZM240-280l120-160 90 120 33-44-283-283v447h447l-80-80H240Zm297-257ZM424-424Z"/></svg>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                No se encontraron pagos con esos filtros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pagos->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $pagos->links() }}
            </div>
        @endif
    </div>
</div>
</x-app-layout>

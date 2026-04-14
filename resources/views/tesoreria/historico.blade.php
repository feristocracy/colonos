<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Histórico financiero
        </h2>
    </x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Histórico financiero</h1>
            <p class="text-sm text-slate-500 mt-1">
                Bitácora de movimientos registrados en el sistema
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('tesoreria.index') }}"
               class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Volver a Tesorería
            </a>
        </div>
    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Fecha registro
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Hora
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Usuario
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Acción
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Fecha movimiento
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Concepto
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Origen
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Referencia
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Monto
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
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

                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $movimiento->created_at?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $movimiento->created_at?->format('H:i:s') ?? '—' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $movimiento->usuarioCreador->name ?? 'Sistema' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $accion }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $movimiento->fecha?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700">
                                <div class="font-medium">{{ $movimiento->concepto }}</div>

                                @if($movimiento->comentarios)
                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ $movimiento->comentarios }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700">
                                @if($movimiento->origen === 'pago_colono')
                                    <span class="inline-flex rounded-full bg-violet-100 px-2.5 py-1 text-xs font-semibold text-violet-700">
                                        Pago de cuota
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                        Manual
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $referencia }}
                            </td>

                            <td class="px-4 py-3 text-sm font-semibold {{ $movimiento->tipo === 'ingreso' ? 'text-emerald-600' : 'text-rose-600' }}">
                                ${{ number_format($movimiento->monto, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-sm text-slate-500">
                                No hay movimientos registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-4 py-4">
            {{ $movimientos->links() }}
        </div>
    </div>
</div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tesoreria
        </h2>
    </x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Tesorería</h1>
            <p class="text-sm text-slate-500 mt-1">
                Estado financiero de la asociación
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('tesoreria.print', ['mes' => $mes, 'anio' => $anio]) }}"
               target="_blank"
               class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Imprimir mes
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-5">
            <p class="text-sm text-slate-500">Saldo actual en caja</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">${{ number_format($saldoActual, 2) }}</p>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-5">
            <p class="text-sm text-slate-500">Ingresos del mes</p>
            <p class="mt-2 text-2xl font-bold text-emerald-600">${{ number_format($ingresosMes, 2) }}</p>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-5">
            <p class="text-sm text-slate-500">Egresos del mes</p>
            <p class="mt-2 text-2xl font-bold text-rose-600">${{ number_format($egresosMes, 2) }}</p>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-5">
            <p class="text-sm text-slate-500">Balance del mes</p>
            <p class="mt-2 text-2xl font-bold {{ $balanceMes >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                ${{ number_format($balanceMes, 2) }}
            </p>
        </div>
    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-5 mb-8">
        <form method="GET" action="{{ route('tesoreria.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Mes</label>
                <select name="mes" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500">
                    @foreach(range(1, 12) as $numeroMes)
                        <option value="{{ $numeroMes }}" {{ (int)$mes === $numeroMes ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($numeroMes)->locale('es')->monthName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Año</label>
                <select name="anio" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500">
                    @foreach(range(now()->year - 5, now()->year + 1) as $year)
                        <option value="{{ $year }}" {{ (int)$anio === $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tipo</label>
                <select name="tipo" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500">
                    <option value="">Todos</option>
                    <option value="ingreso" {{ $tipo === 'ingreso' ? 'selected' : '' }}>Ingresos</option>
                    <option value="egreso" {{ $tipo === 'egreso' ? 'selected' : '' }}>Egresos</option>
                </select>
            </div>

            <div class="flex items-end">
                <button class="w-full rounded-xl bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-violet-700">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    @if(auth()->user()->role === 'tesorero')
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-5 mb-8">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Registrar movimiento</h2>

            <form method="POST" action="{{ route('tesoreria.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tipo</label>
                    <select name="tipo" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500" required>
                        <option value="">Seleccione</option>
                        <option value="ingreso">Ingreso</option>
                        <option value="egreso">Egreso</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Fecha</label>
                    <input type="date" name="fecha" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Monto</label>
                    <input type="number" name="monto" step="0.01" min="0.01" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Categoría</label>
                    <input type="text" name="categoria" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Concepto</label>
                    <input type="text" name="concepto" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Comentarios</label>
                    <textarea name="comentarios" rows="3" class="w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Comprobante</label>
                    <input type="file" name="comprobante" accept="image/*" class="block w-full text-sm text-slate-600">
                </div>

                <div class="md:col-span-2">
                    <button class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                        Guardar movimiento
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tipo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Concepto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Categoría</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Origen</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Monto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Comprobante</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($movimientos as $movimiento)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $movimiento->fecha->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $movimiento->tipo === 'ingreso' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($movimiento->tipo) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700">
                                <div class="font-medium">{{ $movimiento->concepto }}</div>
                                @if($movimiento->comentarios)
                                    <div class="text-slate-500 text-xs mt-1">{{ $movimiento->comentarios }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $movimiento->categoria ?? '—' }}</td>
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
                            <td class="px-4 py-3 text-sm font-semibold {{ $movimiento->tipo === 'ingreso' ? 'text-emerald-600' : 'text-rose-600' }}">
                                ${{ number_format($movimiento->monto, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700">
                                @if($movimiento->comprobante_path)
                                    <a href="{{ asset('storage/' . $movimiento->comprobante_path) }}"
                                       target="_blank"
                                       class="text-violet-600 hover:text-violet-800 font-medium">
                                        Ver comprobante
                                    </a>
                                @else
                                <a href="{{ asset('storage/' . $colono->pagos->recibo_path) }}"
                                    target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm40-80h480L570-480 450-320l-90-120-120 160Zm-40 80v-560 560Z"/></svg>
                                </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">
                                No hay movimientos registrados para este periodo.
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
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle del colono
            </h2>

            <a href="{{ route('colonos.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                Volver
            </a>
        </div>
    </x-slot>

    <div
        class="py-8"
        x-data="{ openPagoModal: {{ $errors->any() ? 'true' : 'false' }} }"
        @keydown.escape.window="openPagoModal = false; $refs.miForm2.reset()"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $colono->nombre_completo }}
                            </h1>

                            @if(auth()->user()->isTesorero())
                                <div class="mt-6">
                                    <button
                                        type="button"
                                        @click="openPagoModal = true"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition"
                                    >
                                        Agregar pago
                                    </button>
                                </div>
                            @endif

                            <div class="mt-6 space-y-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Dirección</p>
                                    <p class="text-sm text-gray-800 mt-1">
                                        {{ $colono->direccion }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Teléfono</p>
                                    <p class="text-sm text-gray-800 mt-1">
                                        {{ $colono->telefono ?: 'Sin teléfono' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Correo</p>
                                    <p class="text-sm text-gray-800 mt-1">
                                        {{ $colono->correo ?: 'Sin correo' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Total de pagos</p>
                                    <p class="text-sm text-gray-800 mt-1">
                                        {{ $colono->pagos->count() }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Monto acumulado</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-1">
                                        ${{ number_format($colono->pagos->sum('monto'), 2) }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Status</p>

                                    @if($colono->esta_al_corriente)
                                        <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            Al corriente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Con adeudo
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-500">Último mes pagado</p>
                                    <p class="text-sm text-gray-800 mt-1">
                                        @if($colono->ultimo_periodo_pagado)
                                            {{ \Carbon\Carbon::createFromFormat('Y-m', $colono->ultimo_periodo_pagado)->translatedFormat('F Y') }}
                                        @else
                                            Sin pagos registrados
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Historial de pagos</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Pagos registrados para este colono.
                                    </p>
                                </div>
                                <a href="{{ route('colonos.estado-cuenta.pdf', $colono) }}"
                                    target="_blank"
                                    class="shrink-0 inline-flex items-center px-4 py-2 bg-violet-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-violet-700 transition">
                                        Imprimir estado de cuenta
                                </a>
                            </div>

                            @if($colono->pagos->count())
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Mes(es) cubierto(s)
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Folio
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Fecha
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Observaciones
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Monto
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Recibo
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($colono->pagos as $pago)
                                                <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    @if($pago->periodos->count())
                                                        <div class="flex flex-col gap-1">
                                                            @foreach($pago->periodos as $periodo)
                                                                <span>
                                                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $periodo->periodo)->translatedFormat('F Y') }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400">Sin periodos</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ $pago->folio }}
                                                </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                        {{ $pago->fecha_pago->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">
                                                        {{ $pago->observaciones ?: 'Sin observaciones' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        ${{ number_format($pago->monto, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        @if($pago->recibo_path)
                                                            <a href="{{ asset('storage/' . $pago->recibo_path) }}"
                                                               target="_blank"
                                                               class="text-indigo-600 hover:text-indigo-800 font-medium">
                                                                Ver recibo
                                                            </a>
                                                        @else
                                                            <span class="text-gray-400">Sin recibo</span>
                                                        @endif
                                                    </td>                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                                    Este colono todavía no tiene pagos registrados.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->isTesorero())
            <div
                x-show="openPagoModal"
                x-transition.opacity
                class="fixed inset-0 bg-black/50 z-40"
                style="display: none;"
                @click="openPagoModal = false"
            ></div>

            <div
                x-show="openPagoModal"
                x-transition
                class="fixed inset-0 z-50 flex items-center justify-center px-4"
                style="display: none;"
            >
                <div
                    class="max-h-[90vh] flex flex-col bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden p-4 overflow-y-auto flex-grow scrollbar-thin scrollbar-thumb-gray-400"
                    @click.stop
                >
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Registrar pago</h3>
                            <p class="text-sm text-gray-500">
                                {{ $colono->nombre_completo }}
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="openPagoModal = false"
                            class="text-gray-400 hover:text-gray-600 text-2xl leading-none"
                        >
                            &times;
                        </button>
                    </div>

                    <form action="{{ route('colonos.pagos.store', $colono) }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="p-6 space-y-5"
                          x-ref="miForm2">
                        @csrf

                        @if ($errors->any())
                            <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                                <p class="text-sm font-semibold text-red-800 mb-2">Hay errores en el formulario:</p>
                                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Meses cubiertos
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-64 overflow-y-auto border border-gray-200 rounded-md p-3">
                                @foreach($mesesDisponibles as $mes)
                                    @php
                                        $yaPagado = $colono->pagoPeriodos->contains('periodo', $mes['value']);
                                    @endphp

                                    <label class="flex items-center gap-2 text-sm {{ $yaPagado ? 'text-gray-400' : 'text-gray-700' }}">
                                        <input
                                            type="checkbox"
                                            name="periodos[]"
                                            value="{{ $mes['value'] }}"
                                            {{ in_array($mes['value'], old('periodos', [])) ? 'checked' : '' }}
                                            {{ $yaPagado ? 'disabled' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        >
                                        <span>
                                            {{ ucfirst($mes['label']) }}
                                            @if($yaPagado)
                                                <span class="text-xs text-red-400">(ya pagado)</span>
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <p class="text-xs text-gray-500 mt-2">
                                Puedes seleccionar uno o varios meses en un solo pago.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="folio" class="block text-sm font-medium text-gray-700 mb-1">
                                    Folio del recibo
                                </label>
                                <input
                                    type="text"
                                    name="folio"
                                    id="folio"
                                    value="{{ old('folio') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                            </div>
                            <div>
                                <label for="fecha_pago" class="block text-sm font-medium text-gray-700 mb-1">
                                    Fecha de pago
                                </label>
                                <input
                                    type="date"
                                    name="fecha_pago"
                                    id="fecha_pago"
                                    value="{{ old('fecha_pago', now()->format('Y-m-d')) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                            </div>
                        </div>

                            <div>
                                <label for="monto" class="block text-sm font-medium text-gray-700 mb-1">
                                    Monto
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0.01"
                                    name="monto"
                                    id="monto"
                                    value="{{ old('monto') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                            </div>
                        </div>

                        <div>
                            <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">
                                Observaciones (opcional)
                            </label>
                            <input
                                type="text"
                                name="observaciones"
                                id="observaciones"
                                value="{{ old('observaciones') }}"
                                placeholder="Ej. Pagó varios meses"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <div>
                            <label for="recibo" class="block text-sm font-medium text-gray-700 mb-1">
                                Imagen del recibo
                            </label>
                            <input
                                type="file"
                                name="recibo"
                                id="recibo"
                                accept=".jpg,.jpeg,.png,.webp,image/*"
                                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                            >
                            <p class="text-xs text-gray-500 mt-1">
                                Formatos permitidos: JPG, JPEG, PNG, WEBP. Máximo 4 MB.
                            </p>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button
                                type="button"
                                @click="openPagoModal = false; $refs.miForm2.reset()"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition"
                            >
                                Guardar pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

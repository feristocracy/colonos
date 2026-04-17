<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-violet-900 leading-tight">
                Detalle del Colono
            </h2>

            <a href="{{ route('colonos.index') }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-700 hover:bg-violet-50 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div
        class="py-8 bg-gray-50/50 min-h-screen"
        x-data="{ openPagoModal: {{ $errors->any() ? 'true' : 'false' }} }"
        @keydown.escape.window="openPagoModal = false; $refs.miForm2.reset()"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alertas -->
            @if(session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 flex items-center shadow-sm">
                    <svg class="h-5 w-5 text-emerald-400 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
                
                <!-- Columna Izquierda: Info del Colono -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-3xl border border-violet-100 overflow-hidden relative">
                        <!-- Fondo decorativo -->
                        <div class="absolute top-0 left-0 w-full h-28 bg-gradient-to-b from-violet-100/60 to-white"></div>
                        
                        <div class="p-6 sm:p-8 relative">
                            <!-- Avatar -->
                            <div class="flex items-center justify-center mb-5 mt-2">
                                <div class="h-24 w-24 rounded-full bg-violet-100 flex items-center justify-center text-violet-600 font-extrabold text-4xl border-4 border-white shadow-md">
                                    {{ strtoupper(substr($colono->nombre_completo, 0, 1)) }}
                                </div>
                            </div>

                            <h1 class="text-2xl font-extrabold text-violet-900 text-center mb-6 tracking-tight leading-tight">
                                {{ $colono->nombre_completo }}
                            </h1>

                            @if(auth()->user()->isTesorero())
                                <div class="flex justify-center mb-8">
                                    <button
                                        type="button"
                                        @click="openPagoModal = true"
                                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:from-violet-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5 w-full"
                                    >
                                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Registrar Pago
                                    </button>
                                </div>
                            @endif

                            <div class="space-y-5 border-t border-violet-50 pt-6">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Dirección</p>
                                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $colono->direccion }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Teléfono</p>
                                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $colono->telefono ?: 'Sin teléfono' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Correo</p>
                                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $colono->correo ?: 'Sin correo' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Total de Pagos</p>
                                        <p class="text-sm text-gray-800 font-bold mt-0.5">{{ $colono->pagos->count() }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-emerald-50 rounded-lg text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Monto Acumulado</p>
                                        <p class="text-lg font-extrabold text-emerald-600 mt-0.5 tracking-tight">${{ number_format($colono->pagos->sum('monto'), 2) }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Status</p>
                                        <div class="mt-1.5">
                                            @if($colono->esta_al_corriente)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                                                    Al corriente
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200 shadow-sm">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-2"></span>
                                                    Con adeudo
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Último mes pagado</p>
                                        <p class="text-sm text-gray-800 font-medium mt-0.5 capitalize">
                                            @if($colono->ultimo_periodo_pagado)
                                                {{ \Carbon\Carbon::createFromFormat('Y-m', $colono->ultimo_periodo_pagado)->translatedFormat('F Y') }}
                                            @else
                                                <span class="text-gray-400 italic">Sin pagos registrados</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Historial de Pagos -->
                <div class="lg:col-span-2 h-full">
                    <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-3xl border border-violet-100 overflow-hidden h-full flex flex-col">
                        <div class="p-6 sm:p-8 flex-grow">
                            <!-- Encabezado de Pagos -->
                            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <h3 class="text-xl font-extrabold text-violet-900 tracking-tight">Historial de Pagos</h3>
                                    <p class="mt-1 text-sm text-violet-600/80">
                                        Registro de todos los pagos realizados por este colono.
                                    </p>
                                </div>
                                <a href="{{ route('colonos.estado-cuenta.pdf', $colono) }}"
                                    target="_blank"
                                    class="shrink-0 inline-flex items-center justify-center px-5 py-2.5 bg-violet-50 border border-violet-200 rounded-xl font-semibold text-sm text-violet-800 hover:bg-violet-100 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all w-full sm:w-auto shadow-sm">
                                    <svg class="w-5 h-5 mr-2 -ml-1 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Estado de Cuenta
                                </a>
                            </div>

                            @if($colono->pagos->count())
                                <div class="overflow-hidden rounded-xl border border-violet-100 shadow-sm bg-white">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-violet-100">
                                            <thead class="bg-violet-50/80">
                                                <tr>
                                                    <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Meses Cubiertos</th>
                                                    <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Folio</th>
                                                    <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Fecha</th>
                                                    <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Observaciones</th>
                                                    <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">Monto</th>
                                                    <th scope="col" class="px-4 sm:px-6 py-4 text-center text-xs font-bold text-violet-800 uppercase tracking-wider">Recibo</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-violet-50">
                                                @foreach($colono->pagos as $pago)
                                                    <tr class="hover:bg-violet-50/60 transition-colors group">
                                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">
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
                                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-semibold text-violet-900">
                                                            {{ $pago->folio }}
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                            {{ $pago->fecha_pago->format('d/m/Y') }}
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-600 max-w-[200px] truncate" title="{{ $pago->observaciones }}">
                                                            {{ $pago->observaciones ?: 'Sin observaciones' }}
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600">
                                                            ${{ number_format($pago->monto, 2) }}
                                                        </td>
                                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center">
                                                            @if($pago->recibo_path)
                                                                <a href="{{ asset('storage/' . $pago->recibo_path) }}"
                                                                   target="_blank"
                                                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-violet-50 text-violet-600 hover:bg-violet-100 hover:text-violet-800 transition-colors border border-violet-200 shadow-sm"
                                                                   title="Ver recibo">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                </a>
                                                            @else
                                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 border border-gray-200" title="Sin recibo">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                                </span>
                                                            @endif
                                                        </td>                                                    
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <!-- Estado Vacío Historial -->
                                <div class="flex flex-col items-center justify-center py-12 px-4 text-center bg-violet-50/50 rounded-2xl border border-dashed border-violet-200 mt-4">
                                    <div class="h-16 w-16 bg-violet-100 text-violet-500 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-violet-900 mb-1">Aún no hay pagos registrados</h3>
                                    <p class="text-sm text-violet-600 max-w-sm mb-6">Este colono no tiene historial de pagos. Agrega un pago para comenzar a llevar su registro.</p>
                                    @if(auth()->user()->isTesorero())
                                        <button type="button" @click="openPagoModal = true" class="inline-flex items-center justify-center px-5 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                                            Registrar primer pago
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Pago -->
        @if(auth()->user()->isTesorero())
            <!-- Fondo Oscuro -->
            <div
                x-show="openPagoModal"
                x-transition.opacity.duration.300ms
                class="fixed inset-0 bg-violet-900/40 backdrop-blur-sm z-40"
                style="display: none;"
                @click="openPagoModal = false"
            ></div>

            <!-- Contenedor Modal -->
            <div
                x-show="openPagoModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="fixed inset-0 z-50 flex items-center justify-center px-4 pt-4 pb-20 sm:p-0"
                style="display: none;"
            >
                <div
                    class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all"
                    @click.stop
                >
                    <!-- Header Modal -->
                    <div class="bg-gradient-to-r from-violet-50 to-white px-6 py-5 border-b border-violet-100 flex items-center justify-between shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-violet-100 rounded-full flex items-center justify-center text-violet-600 shadow-inner">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-violet-900">Registrar Pago</h3>
                                <p class="text-xs text-violet-500 font-medium mt-0.5">
                                    {{ $colono->nombre_completo }}
                                </p>
                            </div>
                        </div>

                        <button
                            type="button"
                            @click="openPagoModal = false; $refs.miForm2.reset()"
                            class="text-violet-400 hover:text-violet-700 hover:bg-violet-50 p-2 rounded-full transition-colors focus:outline-none"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Formulario con Scroll -->
                    <div class="overflow-y-auto p-6 sm:p-8 custom-scrollbar flex-grow">
                        <form action="{{ route('colonos.pagos.store', $colono) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="space-y-6"
                              x-ref="miForm2">
                            @csrf

                            @if ($errors->any())
                                <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 flex gap-3">
                                    <svg class="h-5 w-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <div>
                                        <p class="text-sm font-bold text-rose-800 mb-1">Por favor corrige los siguientes errores:</p>
                                        <ul class="list-disc list-inside text-sm text-rose-700 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-violet-900 mb-2">
                                        Meses cubiertos
                                    </label>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-56 overflow-y-auto border border-violet-100 rounded-xl p-3 bg-violet-50/30 custom-scrollbar">
                                        @foreach($mesesDisponibles as $mes)
                                            @php
                                                $yaPagado = $colono->pagoPeriodos->contains('periodo', $mes['value']);
                                            @endphp

                                            <label class="flex items-center gap-3 p-2.5 rounded-lg transition-all {{ $yaPagado ? 'opacity-60 cursor-not-allowed bg-gray-50' : 'hover:bg-white cursor-pointer border border-transparent hover:border-violet-200 hover:shadow-sm' }}">
                                                <input
                                                    type="checkbox"
                                                    name="periodos[]"
                                                    value="{{ $mes['value'] }}"
                                                    {{ in_array($mes['value'], old('periodos', [])) ? 'checked' : '' }}
                                                    {{ $yaPagado ? 'disabled' : '' }}
                                                    class="w-4 h-4 rounded border-violet-300 text-violet-600 shadow-sm focus:ring-violet-500 focus:ring-offset-0 disabled:bg-gray-200 transition-colors"
                                                >
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-medium {{ $yaPagado ? 'text-gray-500' : 'text-violet-900' }}">
                                                        {{ ucfirst($mes['label']) }}
                                                    </span>
                                                    @if($yaPagado)
                                                        <span class="text-xs font-bold text-rose-500 mt-0.5">Ya pagado</span>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>

                                    <p class="text-xs text-violet-500 mt-2 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Puedes seleccionar uno o varios meses en un solo pago.
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="folio" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                            Folio del recibo <span class="text-rose-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            name="folio"
                                            id="folio"
                                            value="{{ old('folio') }}"
                                            placeholder="Ej. 00123"
                                            class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label for="fecha_pago" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                            Fecha de pago <span class="text-rose-500">*</span>
                                        </label>
                                        <input
                                            type="date"
                                            name="fecha_pago"
                                            id="fecha_pago"
                                            value="{{ old('fecha_pago', now()->format('Y-m-d')) }}"
                                            class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                            required
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label for="monto" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                        Monto <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-violet-500 sm:text-sm font-bold">$</span>
                                        </div>
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0.01"
                                            name="monto"
                                            id="monto"
                                            value="{{ old('monto') }}"
                                            placeholder="0.00"
                                            class="block w-full rounded-xl border-violet-200 bg-white pl-8 pr-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                            required
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label for="observaciones" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                        Observaciones (opcional)
                                    </label>
                                    <input
                                        type="text"
                                        name="observaciones"
                                        id="observaciones"
                                        value="{{ old('observaciones') }}"
                                        placeholder="Ej. Pagó varios meses por adelantado"
                                        class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                    >
                                </div>

                                <div>
                                    <label for="recibo" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                        Imagen del recibo
                                    </label>
                                    <input
                                        type="file"
                                        name="recibo"
                                        id="recibo"
                                        accept=".jpg,.jpeg,.png,.webp,image/*"
                                        class="block w-full text-sm text-violet-700 border border-violet-200 rounded-xl shadow-sm bg-white file:mr-4 file:py-2.5 file:px-4 file:border-0 file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 transition-all focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 cursor-pointer"
                                    >
                                    <p class="text-xs text-violet-500 mt-2 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Formatos permitidos: JPG, JPEG, PNG, WEBP. Máximo 4 MB.
                                    </p>
                                </div>
                            </div>

                            <!-- Acciones Modal -->
                            <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-violet-50">
                                <button
                                    type="button"
                                    @click="openPagoModal = false; $refs.miForm2.reset()"
                                    class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-700 hover:bg-violet-50 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all"
                                >
                                    Cancelar
                                </button>

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center px-6 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all"
                                >
                                    Guardar pago
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <style>
        /* Estilos personalizados para la barra de desplazamiento del modal */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #ddd6fe; /* violet-200 */
            border-radius: 20px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #c4b5fd; /* violet-300 */
        }
    </style>
</x-app-layout>

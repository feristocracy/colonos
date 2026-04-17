<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-violet-900 leading-tight">
            Gestión de Colonos
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen" x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }} }"
        @keydown.escape.window="openModal = false; $refs.miForm.reset()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Contenedor Principal -->
            <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-2xl border border-violet-100 overflow-hidden">
                <div class="p-4 sm:p-8">
                    
                    <!-- Encabezado y Acciones -->
                    <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-violet-900 tracking-tight">Directorio de Colonos</h1>
                            <p class="mt-2 text-sm text-violet-600/80">Administra la información y el estado de pagos de los residentes.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <form action="{{ route('colonos.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                                <div class="relative w-full sm:w-80">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Buscar colono..."
                                        class="block w-full pl-10 pr-3 py-2.5 border-violet-200 rounded-xl text-sm shadow-sm placeholder-violet-300 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-colors"
                                    >
                                </div>

                                <div class="flex gap-2">
                                    <button
                                        type="submit"
                                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-2.5 bg-violet-100 border border-transparent rounded-xl font-semibold text-sm text-violet-800 hover:bg-violet-200 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all"
                                    >
                                        Buscar
                                    </button>

                                    @if(request('search'))
                                        <a
                                            href="{{ route('colonos.index') }}"
                                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-2.5 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-600 hover:bg-violet-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all"
                                        >
                                            Limpiar
                                        </a>
                                    @endif
                                </div>
                            </form>

                            <button
                                type="button"
                                @click="openModal = true"
                                class="inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:from-violet-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5 w-full sm:w-auto"
                            >
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nuevo Colono
                            </button>
                        </div>
                    </div>

                    <!-- Alertas -->
                    @if(session('success'))
                        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 flex items-center shadow-sm">
                            <svg class="h-5 w-5 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(request('search'))
                        <div class="mb-4 text-sm text-violet-600 bg-violet-50 inline-block px-4 py-1.5 rounded-full border border-violet-100">
                            Mostrando resultados para: <span class="font-bold text-violet-900">"{{ request('search') }}"</span>
                        </div>
                    @endif

                    <!-- Tabla -->
                    @if($colonos->count())
                        <div class="overflow-hidden rounded-xl border border-violet-100 shadow-sm bg-white">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-violet-100">
                                    <thead class="bg-violet-50/80">
                                        <tr>
                                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">
                                                <a href="{{ route('colonos.index', ['search' => request('search'), 'sort' => 'nombre_completo', 'direction' => ($sort === 'nombre_completo' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="group flex items-center gap-2 hover:text-violet-600 transition-colors">
                                                    Nombre Completo
                                                    <span class="flex flex-col text-[10px] leading-none">
                                                        <span class="{{ $sort === 'nombre_completo' && $direction === 'asc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▲</span>
                                                        <span class="{{ $sort === 'nombre_completo' && $direction === 'desc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▼</span>
                                                    </span>
                                                </a>
                                            </th>
                                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">
                                                <a href="{{ route('colonos.index', ['search' => request('search'), 'sort' => 'direccion', 'direction' => ($sort === 'direccion' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="group flex items-center gap-2 hover:text-violet-600 transition-colors">
                                                    Dirección
                                                    <span class="flex flex-col text-[10px] leading-none">
                                                        <span class="{{ $sort === 'direccion' && $direction === 'asc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▲</span>
                                                        <span class="{{ $sort === 'direccion' && $direction === 'desc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▼</span>
                                                    </span>
                                                </a>
                                            </th>
                                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">
                                                <a href="{{ route('colonos.index', ['search' => request('search'), 'sort' => 'telefono', 'direction' => ($sort === 'telefono' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="group flex items-center gap-2 hover:text-violet-600 transition-colors">
                                                    Teléfono
                                                    <span class="flex flex-col text-[10px] leading-none">
                                                        <span class="{{ $sort === 'telefono' && $direction === 'asc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▲</span>
                                                        <span class="{{ $sort === 'telefono' && $direction === 'desc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▼</span>
                                                    </span>
                                                </a>
                                            </th>
                                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">
                                                <a href="{{ route('colonos.index', ['search' => request('search'), 'sort' => 'correo', 'direction' => ($sort === 'correo' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="group flex items-center gap-2 hover:text-violet-600 transition-colors">
                                                    Correo
                                                    <span class="flex flex-col text-[10px] leading-none">
                                                        <span class="{{ $sort === 'correo' && $direction === 'asc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▲</span>
                                                        <span class="{{ $sort === 'correo' && $direction === 'desc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▼</span>
                                                    </span>
                                                </a>
                                            </th>
                                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">
                                                Último Pago
                                            </th>
                                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-violet-800 uppercase tracking-wider">
                                                <a href="{{ route('colonos.index', ['search' => request('search'), 'sort' => 'status', 'direction' => ($sort === 'status' && $direction === 'asc') ? 'desc' : 'asc']) }}" class="group flex items-center gap-2 hover:text-violet-600 transition-colors">
                                                    Status
                                                    <span class="flex flex-col text-[10px] leading-none">
                                                        <span class="{{ $sort === 'status' && $direction === 'asc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▲</span>
                                                        <span class="{{ $sort === 'status' && $direction === 'desc' ? 'text-violet-700' : 'text-violet-300 group-hover:text-violet-400' }}">▼</span>
                                                    </span>
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-violet-50">
                                        @foreach($colonos as $colono)
                                            <tr class="hover:bg-violet-50/60 cursor-pointer transition-colors duration-200 group"
                                            onclick="window.location = `{{ route('colonos.show', $colono) }}`">
                                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-violet-100 flex items-center justify-center text-violet-600 font-bold text-sm border border-violet-200">
                                                            {{ strtoupper(substr($colono->nombre_completo, 0, 1)) }}
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-violet-700 transition-colors">{{ $colono->nombre_completo }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-violet-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        <span class="truncate max-w-[200px]" title="{{ $colono->direccion }}">{{ $colono->direccion }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                        {{ $colono->telefono ?: 'Sin teléfono' }}
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                        {{ $colono->correo ?: 'Sin correo' }}
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    @if($colono->ultimo_periodo_pagado)
                                                        <div class="flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                            <span class="capitalize">{{ \Carbon\Carbon::createFromFormat('Y-m', $colono->ultimo_periodo_pagado)->translatedFormat('M Y') }}</span>
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400 italic">Sin registros</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
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
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-6">
                            {{ $colonos->links() }}
                        </div>
                    @else
                        <!-- Estado vacío -->
                        <div class="flex flex-col items-center justify-center py-12 px-4 text-center bg-violet-50/50 rounded-2xl border border-dashed border-violet-200">
                            <div class="h-16 w-16 bg-violet-100 text-violet-500 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-violet-900 mb-1">No hay colonos registrados</h3>
                            <p class="text-sm text-violet-600 max-w-sm mb-6">Comienza agregando un nuevo colono al directorio para llevar su control de pagos.</p>
                            <button type="button" @click="openModal = true" class="inline-flex items-center justify-center px-5 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 transition-colors">
                                Agregar primer colono
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Fondo oscuro modal -->
        <div x-show="openModal" x-transition.opacity.duration.300ms class="fixed inset-0 bg-violet-900/40 backdrop-blur-sm z-40" style="display: none;"
            @click="openModal = false"></div>

        <!-- Modal -->
        <div x-show="openModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="fixed inset-0 z-50 flex items-center justify-center px-4 pt-4 pb-20 sm:p-0"
            style="display: none;">
            
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all" @click.stop>
                
                <div class="bg-gradient-to-r from-violet-50 to-white px-6 py-5 border-b border-violet-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-violet-100 rounded-full flex items-center justify-center text-violet-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-violet-900">Nuevo Colono</h3>
                            <p class="text-xs text-violet-500 font-medium mt-0.5">Ingresa los datos para registrar un residente</p>
                        </div>
                    </div>

                    <button type="button" @click="openModal = false; $refs.miForm.reset()"
                        class="text-violet-400 hover:text-violet-700 hover:bg-violet-50 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form x-ref="miForm" action="{{ route('colonos.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
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

                    <div class="space-y-5">
                        <div>
                            <label for="nombre_completo" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                Nombre completo <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nombre_completo" id="nombre_completo"
                                value="{{ old('nombre_completo') }}"
                                placeholder="Ej. Juan Pérez García"
                                class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                required>
                        </div>

                        <div>
                            <label for="direccion" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                Dirección <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                                placeholder="Ej. Calle Primavera 123"
                                class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="telefono" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                    Teléfono <span class="text-rose-500">*</span>
                                </label>
                                <input type="tel" name="telefono" id="telefono" value="{{ old('telefono') }}"
                                    placeholder="10 dígitos"
                                    class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all">
                            </div>

                            <div>
                                <label for="correo" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                    Correo electrónico
                                </label>
                                <input type="email" name="correo" id="correo" value="{{ old('correo') }}"
                                    placeholder="ejemplo@correo.com"
                                    class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 mt-6 border-t border-violet-50">
                        <button type="button" @click="openModal = false; $refs.miForm.reset()"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-700 hover:bg-violet-50 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all">
                            Guardar colono
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

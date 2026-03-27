<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Colonos
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }} }"
        @keydown.escape.window="openModal = false; $refs.miForm.reset()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <div class="px-4 mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Listado de colonos</h1>
                        </div>

                        <div class="flex flex-col gap-3 sm:items-end">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                                <form action="{{ route('colonos.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                                    <div class="w-full sm:w-80">
                                        <input
                                            type="text"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Buscar por nombre, teléfono, correo o dirección..."
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition"
                                        >
                                            Buscar
                                        </button>

                                        @if(request('search'))
                                            <a
                                                href="{{ route('colonos.index') }}"
                                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition"
                                            >
                                                Limpiar
                                            </a>
                                        @endif
                                    </div>
                                </form>

                                <button
                                    type="button"
                                    @click="openModal = true"
                                    class="inline-flex items-center px-4 py-2 bg-violet-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-violet-700 transition"
                                >
                                    Nuevo colono
                                </button>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(request('search'))
                        <div class="px-4 mb-2 text-sm text-gray-600">
                            Mostrando resultados para:
                            <span class="font-semibold text-gray-800">"{{ request('search') }}"</span>
                        </div>
                    @endif

                    @if($colonos->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('colonos.index', [
                                            'search' => request('search'),
                                            'sort' => 'nombre_completo',
                                            'direction' => ($sort === 'nombre_completo' && $direction === 'asc') ? 'desc' : 'asc'
                                            ]) }}"
                                            class="flex items-center gap-2 hover:text-gray-800">

                                            <span>Nombre completo</span>

                                            <span class="flex flex-col text-[10px] leading-none">

                                            <span class="{{ $sort === 'nombre_completo' && $direction === 'asc' ? 'text-black' : 'text-gray-400' }}">
                                            ▲
                                            </span>

                                            <span class="{{ $sort === 'nombre_completo' && $direction === 'desc' ? 'text-black' : 'text-gray-400' }}">
                                            ▼
                                            </span>

                                            </span>

                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('colonos.index', [
                                            'search' => request('search'),
                                            'sort' => 'direccion',
                                            'direction' => ($sort === 'direccion' && $direction === 'asc') ? 'desc' : 'asc'
                                            ]) }}"
                                            class="flex items-center gap-2 hover:text-gray-800">

                                            <span>Dirección</span>

                                            <span class="flex flex-col text-[10px] leading-none">

                                            <span class="{{ $sort === 'direccion' && $direction === 'asc' ? 'text-black' : 'text-gray-400' }}">
                                            ▲
                                            </span>

                                            <span class="{{ $sort === 'direccion' && $direction === 'desc' ? 'text-black' : 'text-gray-400' }}">
                                            ▼
                                            </span>

                                            </span>

                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('colonos.index', [
                                                'search' => request('search'),
                                                'sort' => 'telefono',
                                                'direction' => ($sort === 'telefono' && $direction === 'asc') ? 'desc' : 'asc'
                                            ]) }}" class="flex items-center gap-2 hover:text-gray-800">

                                                <span>Teléfono</span>

                                            <span class="flex flex-col text-[10px] leading-none">

                                            <span class="{{ $sort === 'telefono' && $direction === 'asc' ? 'text-black' : 'text-gray-400' }}">
                                            ▲
                                            </span>

                                            <span class="{{ $sort === 'telefono' && $direction === 'desc' ? 'text-black' : 'text-gray-400' }}">
                                            ▼
                                            </span>

                                            </span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('colonos.index', [
                                                'search' => request('search'),
                                                'sort' => 'correo',
                                                'direction' => ($sort === 'correo' && $direction === 'asc') ? 'desc' : 'asc'
                                            ]) }}" class="flex items-center gap-2 hover:text-gray-800">

                                                <span>Correo</span>

                                            <span class="flex flex-col text-[10px] leading-none">

                                            <span class="{{ $sort === 'correo' && $direction === 'asc' ? 'text-black' : 'text-gray-400' }}">
                                            ▲
                                            </span>

                                            <span class="{{ $sort === 'correo' && $direction === 'desc' ? 'text-black' : 'text-gray-400' }}">
                                            ▼
                                            </span>

                                            </span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Último pago
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('colonos.index', [
                                                'search' => request('search'),
                                                'sort' => 'status',
                                                'direction' => ($sort === 'status' && $direction === 'asc') ? 'desc' : 'asc'
                                            ]) }}" class="flex items-center gap-2 hover:text-gray-800">

                                                <span>Status</span>

                                            <span class="flex flex-col text-[10px] leading-none">

                                            <span class="{{ $sort === 'correo' && $direction === 'asc' ? 'text-black' : 'text-gray-400' }}">
                                            ▲
                                            </span>

                                            <span class="{{ $sort === 'correo' && $direction === 'desc' ? 'text-black' : 'text-gray-400' }}">
                                            ▼
                                            </span>

                                            </span>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($colonos as $colono)
                                        <tr class="hover:bg-gray-100 cursor-pointer transition"
                                        onclick="window.location = `{{ route('colonos.show', $colono) }}`">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $colono->nombre_completo }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                {{ $colono->direccion }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $colono->telefono ?: 'Sin teléfono' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $colono->correo ?: 'Sin correo' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                @if($colono->ultimo_periodo_pagado)
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $colono->ultimo_periodo_pagado)->translatedFormat('M Y') }}
                                                @else
                                                    Sin pagos
                                                @endif
                                            </td>
                                            <td>
                                            @if($colono->esta_al_corriente)
                                                <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    Al corriente
                                                </span>
                                            @else
                                                <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                    Con adeudo
                                                </span>
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $colonos->links() }}
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
                            Aún no hay colonos registrados.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Fondo oscuro -->
        <div x-show="openModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-40" style="display: none;"
            @click="openModal = false"></div>

        <!-- Modal -->
        <div x-show="openModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center px-4"
            style="display: none;">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden" @click.stop>
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Nuevo colono</h3>
                        <p class="text-sm text-gray-500">Captura los datos del colono.</p>
                    </div>

                    <button type="button" @click="openModal = false; $refs.miForm.reset()"
                        class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                        &times;
                    </button>
                </div>

                <form x-ref="miForm" action="{{ route('colonos.store') }}" method="POST" class="p-6 space-y-5">
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

                    <div>
                        <label for="nombre_completo" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre completo<span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nombre_completo" id="nombre_completo"
                            value="{{ old('nombre_completo') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">
                            Dirección<span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">
                                Teléfono<span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="correo" class="block text-sm font-medium text-gray-700 mb-1">
                                Correo
                            </label>
                            <input type="email" name="correo" id="correo" value="{{ old('correo') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="openModal = false; $refs.miForm.reset()"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Guardar colono
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

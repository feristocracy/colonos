<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-violet-900 leading-tight">
                    Editar Colono
                </h2>
                <p class="mt-1 text-sm text-violet-600/80">
                    Actualiza la informacion del residente manteniendo el mismo formato del directorio.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('colonos.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-700 hover:bg-violet-50 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all shadow-sm">
                    Volver al listado
                </a>
                <a href="{{ route('colonos.show', $colono) }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-violet-50 border border-violet-200 rounded-xl font-semibold text-sm text-violet-800 hover:bg-violet-100 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all shadow-sm">
                    Ver detalle
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-3xl border border-violet-100 overflow-hidden relative">
                        <div class="absolute top-0 left-0 w-full h-28 bg-gradient-to-b from-violet-100/60 to-white"></div>

                        <div class="relative p-6 sm:p-8">
                            <div class="flex items-center justify-center mb-5 mt-2">
                                <div class="h-24 w-24 rounded-full bg-violet-100 flex items-center justify-center text-violet-600 font-extrabold text-4xl border-4 border-white shadow-md">
                                    {{ strtoupper(substr($colono->nombre_completo, 0, 1)) }}
                                </div>
                            </div>

                            <h1 class="text-2xl font-extrabold text-violet-900 text-center tracking-tight leading-tight">
                                {{ $colono->nombre_completo }}
                            </h1>

                            <p class="mt-2 text-sm text-violet-600 text-center">
                                Revisa y ajusta los datos de contacto antes de guardar los cambios.
                            </p>

                            <div class="mt-8 space-y-5 border-t border-violet-50 pt-6">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Direccion</p>
                                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $colono->direccion ?: 'Sin direccion registrada' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Telefono</p>
                                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $colono->telefono ?: 'Sin telefono registrado' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 p-2 bg-violet-50 rounded-lg text-violet-500 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-violet-400">Correo</p>
                                        <p class="text-sm text-gray-800 font-medium mt-0.5 break-all">{{ $colono->correo ?: 'Sin correo registrado' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white shadow-xl shadow-violet-100/50 sm:rounded-3xl border border-violet-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-violet-50 to-white px-6 py-5 sm:px-8 border-b border-violet-100">
                            <h3 class="text-xl font-extrabold text-violet-900 tracking-tight">Informacion del colono</h3>
                            <p class="mt-1 text-sm text-violet-600/80">
                                Los cambios se reflejaran en el directorio y en la ficha del colono.
                            </p>
                        </div>

                        <form action="{{ route('colonos.update', $colono) }}" method="POST" class="p-6 sm:p-8 space-y-6">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 flex gap-3">
                                    <svg class="h-5 w-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
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
                                    <input
                                        type="text"
                                        name="nombre_completo"
                                        id="nombre_completo"
                                        value="{{ old('nombre_completo', $colono->nombre_completo) }}"
                                        placeholder="Ej. Juan Perez Garcia"
                                        class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                        required
                                    >
                                    @error('nombre_completo')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="direccion" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                        Direccion
                                    </label>
                                    <input
                                        type="text"
                                        name="direccion"
                                        id="direccion"
                                        value="{{ old('direccion', $colono->direccion) }}"
                                        placeholder="Ej. Calle Primavera 123"
                                        class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                    >
                                    @error('direccion')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="telefono" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                            Telefono
                                        </label>
                                        <input
                                            type="text"
                                            name="telefono"
                                            id="telefono"
                                            value="{{ old('telefono', $colono->telefono) }}"
                                            placeholder="10 digitos"
                                            class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                        >
                                        @error('telefono')
                                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="correo" class="block text-sm font-semibold text-violet-900 mb-1.5">
                                            Correo electronico
                                        </label>
                                        <input
                                            type="email"
                                            name="correo"
                                            id="correo"
                                            value="{{ old('correo', $colono->correo) }}"
                                            placeholder="ejemplo@correo.com"
                                            class="block w-full rounded-xl border-violet-200 bg-white px-4 py-2.5 text-sm shadow-sm placeholder-violet-300 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                                        >
                                        @error('correo')
                                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-4 mt-6 border-t border-violet-50">
                                <a href="{{ route('colonos.show', $colono) }}"
                                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-violet-200 rounded-xl font-semibold text-sm text-violet-700 hover:bg-violet-50 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all">
                                    Cancelar
                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center px-6 py-2.5 bg-violet-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-md shadow-violet-200 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all"
                                >
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a
                href="{{ route('proyectos.index') }}"
                class="group inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                title="Regresar"
            >
                <svg class="h-5 w-5 transition-transform group-hover:-translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>

            <h2 class="text-2xl font-bold tracking-tight text-gray-800">
                Nuevo Proyecto
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form
                method="POST"
                action="{{ route('proyectos.store') }}"
                class="space-y-8 rounded-2xl border border-gray-100 bg-white p-8 shadow-sm ring-1 ring-gray-900/5 sm:p-10"
            >
                @csrf

                <div>
                    <label
                        for="nombre"
                        class="block text-sm font-semibold text-gray-900"
                    >
                        Nombre del proyecto
                    </label>

                    <input
                        id="nombre"
                        name="nombre"
                        type="text"
                        value="{{ old('nombre') }}"
                        required
                        maxlength="255"
                        class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                        placeholder="Ej. Remodelación del parque central"
                    >

                    @error('nombre')
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="descripcion"
                        class="block text-sm font-semibold text-gray-900"
                    >
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="4"
                        required
                        class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                        placeholder="Detalles sobre los objetivos y alcance del proyecto..."
                    >{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="monto_inicial"
                        class="block text-sm font-semibold text-gray-900"
                    >
                        Monto inicial
                    </label>

                    <div class="relative mt-2">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>

                        <input
                            id="monto_inicial"
                            name="monto_inicial"
                            type="number"
                            value="{{ old('monto_inicial') }}"
                            min="0"
                            step="0.01"
                            required
                            class="block w-full rounded-lg border-gray-300 py-2.5 pl-9 text-gray-900 shadow-sm transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                            placeholder="0.00"
                        >
                    </div>

                    <p class="mt-2 flex items-center gap-1.5 text-xs text-gray-500">
                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Este monto quedará fijo. Modificaciones posteriores deberán registrarse como entradas o salidas.
                    </p>

                    @error('monto_inicial')
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="lideres"
                        class="block text-sm font-semibold text-gray-900"
                    >
                        Líderes del proyecto
                    </label>

                    <select
                        id="lideres"
                        name="lideres[]"
                        multiple
                        required
                        size="6"
                        class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                    >
                        @foreach ($usuarios as $usuario)
                            <option
                                value="{{ $usuario->id }}"
                                class="rounded-md px-3 py-1.5 hover:bg-violet-50 focus:bg-violet-100"
                                @selected(
                                    in_array(
                                        $usuario->id,
                                        old('lideres', [])
                                    )
                                )
                            >
                                {{ $usuario->name }}
                                @if ($usuario->role === 'admin')
                                    — Administrador
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <p class="mt-2 text-xs text-gray-500">
                        Mantén presionada la tecla <kbd class="rounded border border-gray-200 bg-gray-50 px-1 font-sans text-xs">Ctrl</kbd> en Windows o <kbd class="rounded border border-gray-200 bg-gray-50 px-1 font-sans text-xs">⌘ Cmd</kbd> en Mac para seleccionar varios usuarios.
                    </p>

                    @error('lideres')
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror

                    @error('lideres.*')
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="rounded-xl border border-amber-200/60 bg-amber-50/50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-amber-800">Atención</h3>
                            <div class="mt-1 text-sm text-amber-700">
                                <p>
                                    Una vez creado, el proyecto no podrá editarse ni eliminarse desde la aplicación. Solamente podrán modificarse sus líderes y agregarse información mediante movimientos y archivos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a
                        href="{{ route('proyectos.index') }}"
                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition-all hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-violet-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                    >
                        <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        Crear proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

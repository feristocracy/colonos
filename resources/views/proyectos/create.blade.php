<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a
                href="{{ route('proyectos.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-gray-800"
            >
                ← Regresar
            </a>

            <h2 class="text-xl font-semibold text-gray-800">
                Nuevo proyecto
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form
                method="POST"
                action="{{ route('proyectos.store') }}"
                class="space-y-6 rounded-xl border border-gray-200
                       bg-white p-6 shadow-sm sm:p-8"
            >
                @csrf

                <div>
                    <label
                        for="nombre"
                        class="block text-sm font-semibold text-gray-700"
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
                        class="mt-2 block w-full rounded-md border-gray-300
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('nombre')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        for="descripcion"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="5"
                        required
                        class="mt-2 block w-full rounded-md border-gray-300
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        for="monto_inicial"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Monto inicial
                    </label>

                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0
                                     flex items-center pl-3 text-gray-500">
                            $
                        </span>

                        <input
                            id="monto_inicial"
                            name="monto_inicial"
                            type="number"
                            value="{{ old('monto_inicial') }}"
                            min="0"
                            step="0.01"
                            required
                            class="block w-full rounded-md border-gray-300 pl-8
                                   shadow-sm focus:border-blue-500
                                   focus:ring-blue-500"
                        >
                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        Este monto quedará fijo. Cualquier modificación posterior
                        deberá registrarse como una entrada o salida.
                    </p>

                    @error('monto_inicial')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        for="lideres"
                        class="block text-sm font-semibold text-gray-700"
                    >
                        Líderes del proyecto
                    </label>

                    <select
                        id="lideres"
                        name="lideres[]"
                        multiple
                        required
                        size="8"
                        class="mt-2 block w-full rounded-md border-gray-300
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        @foreach ($usuarios as $usuario)
                            <option
                                value="{{ $usuario->id }}"
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
                        Mantén presionada la tecla Ctrl en Windows o Cmd en Mac
                        para seleccionar varios usuarios.
                    </p>

                    @error('lideres')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @error('lideres.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                    <p class="text-sm text-amber-800">
                        Una vez creado, el proyecto no podrá editarse ni eliminarse
                        desde la aplicación. Solamente podrán modificarse sus líderes
                        y agregarse información mediante movimientos y archivos.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3 border-t
                            border-gray-200 pt-6">
                    <a
                        href="{{ route('proyectos.index') }}"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2
                               text-sm font-semibold text-gray-700
                               hover:bg-gray-50"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="rounded-md bg-blue-600 px-5 py-2 text-sm
                               font-semibold text-white shadow-sm
                               hover:bg-blue-700"
                    >
                        Crear proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
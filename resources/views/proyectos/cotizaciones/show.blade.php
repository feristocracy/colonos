<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Cotización: {{ $cotizacionConcepto->nombre }}
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Proyecto: {{ $proyecto->nombre }}
                </p>
            </div>

            <a
                href="{{ route('proyectos.show', $proyecto) }}"
                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                Volver al proyecto
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            {{-- Concepto --}}
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $cotizacionConcepto->nombre }}
                        </h3>

                        @if ($cotizacionConcepto->descripcion)
                            <p class="mt-2 text-sm text-gray-600">
                                {{ $cotizacionConcepto->descripcion }}
                            </p>
                        @endif

                        <p class="mt-3 text-xs text-gray-400">
                            Creado por {{ $cotizacionConcepto->creador->name }}
                            el {{ $cotizacionConcepto->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    @can('alimentar', $proyecto)
                        <button
                            type="button"
                            onclick="openCotizacionModal()"
                            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                        >
                            Agregar proveedor
                        </button>
                    @endcan
                </div>
            </section>

            {{-- Cotizaciones --}}
            <section class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Cotizaciones registradas
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Comparativa de proveedores, precios, observaciones y archivos adjuntos.
                    </p>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse ($cotizaciones as $cotizacion)
                        <article class="p-6">
                            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <h4 class="text-base font-semibold text-gray-900">
                                            {{ $cotizacion->proveedor }}
                                        </h4>

                                        <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                                            ${{ number_format($cotizacion->precio, 2) }}
                                        </span>
                                    </div>

                                    @if ($cotizacion->observaciones)
                                        <p class="mt-3 text-sm text-gray-600">
                                            {{ $cotizacion->observaciones }}
                                        </p>
                                    @endif

                                    <p class="mt-3 text-xs text-gray-400">
                                        Registrada por {{ $cotizacion->usuario->name }}
                                        el {{ $cotizacion->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>

                                @if (auth()->user()->role === 'admin')
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <button
                                            type="button"
                                            onclick="document.getElementById('archivosModal-{{ $cotizacion->id }}').classList.remove('hidden')"
                                            class="rounded-md bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-200"
                                        >
                                            Agregar archivos
                                        </button>

                                        <button
                                            type="button"
                                            onclick="document.getElementById('comentarioModal-{{ $cotizacion->id }}').classList.remove('hidden')"
                                            class="rounded-md bg-blue-100 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-200"
                                        >
                                            Agregar comentario
                                        </button>
                                    </div>
                                @endif

                                @if ($cotizacion->archivos->isNotEmpty())
                                    <div class="w-full md:w-72">
                                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Archivos
                                        </p>

                                        <div class="space-y-2">
                                            @foreach ($cotizacion->archivos as $archivo)
                                                <a
                                                    href="{{ \Illuminate\Support\Facades\Storage::url($archivo->archivo) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="flex items-center justify-between gap-3 rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                >
                                                    <span class="truncate">
                                                        {{ $archivo->nombre_original }}
                                                    </span>

                                                    <span class="text-xs font-semibold text-blue-600">
                                                        Ver
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if ($cotizacion->comentarios->isNotEmpty())
                                <div class="mt-4 rounded-md bg-gray-50 p-4">
                                    <p class="mb-2 text-xs font-semibold uppercase text-gray-500">
                                        Comentarios
                                    </p>

                                    <div class="space-y-3">
                                        @foreach ($cotizacion->comentarios as $comentario)
                                            <div class="text-sm text-gray-700">
                                                <p>{{ $comentario->comentario }}</p>
                                                <p class="mt-1 text-xs text-gray-400">
                                                    {{ $comentario->usuario->name }} · {{ $comentario->created_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->role === 'admin')
                                <div id="archivosModal-{{ $cotizacion->id }}" class="fixed inset-0 z-50 hidden bg-gray-900/50">
                                    <div class="mx-auto mt-24 w-full max-w-lg rounded-lg bg-white p-6">
                                        <form method="POST" action="{{ route('proyectos.cotizaciones.detalles.archivos.store', [$proyecto, $cotizacionConcepto, $cotizacion]) }}" enctype="multipart/form-data">
                                            @csrf

                                            <label class="block text-sm font-medium text-gray-700">
                                                Agregar archivos
                                            </label>

                                            <input type="file" name="archivos[]" multiple accept=".pdf,image/*" class="mt-2 block w-full text-sm">

                                            <div class="mt-6 flex justify-end gap-2">
                                                <button type="button" onclick="document.getElementById('archivosModal-{{ $cotizacion->id }}').classList.add('hidden')" class="rounded-md border px-4 py-2 text-sm">
                                                    Cancelar
                                                </button>

                                                <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                                                    Guardar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div id="comentarioModal-{{ $cotizacion->id }}" class="fixed inset-0 z-50 hidden bg-gray-900/50">
                                    <div class="mx-auto mt-24 w-full max-w-lg rounded-lg bg-white p-6">
                                        <form method="POST" action="{{ route('proyectos.cotizaciones.detalles.comentarios.store', [$proyecto, $cotizacionConcepto, $cotizacion]) }}">
                                            @csrf

                                            <label class="block text-sm font-medium text-gray-700">
                                                Comentario
                                            </label>

                                            <textarea name="comentario" rows="4" required class="mt-2 block w-full rounded-md border-gray-300"></textarea>

                                            <div class="mt-6 flex justify-end gap-2">
                                                <button type="button" onclick="document.getElementById('comentarioModal-{{ $cotizacion->id }}').classList.add('hidden')" class="rounded-md border px-4 py-2 text-sm">
                                                    Cancelar
                                                </button>

                                                <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                                                    Guardar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                        </article>
                    @empty
                        <div class="px-6 py-10 text-center">
                            <p class="text-sm text-gray-500">
                                Aún no hay cotizaciones registradas para este concepto.
                            </p>
                        </div>
                    @endforelse
                </div>

                @if ($cotizaciones->hasPages())
                    <div class="border-t border-gray-200 px-6 py-4">
                        {{ $cotizaciones->links() }}
                    </div>
                @endif
            </section>
        </div>
    </div>

    @can('alimentar', $proyecto)
        <div
            id="cotizacionModal"
            class="fixed inset-0 z-50 hidden overflow-y-auto"
            role="dialog"
            aria-modal="true"
        >
            <div class="flex min-h-screen items-center justify-center px-4 py-6">
                <div
                    class="fixed inset-0 bg-gray-900 bg-opacity-50"
                    onclick="closeCotizacionModal()"
                ></div>

                <div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl">
                    <div class="mb-5 flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Agregar proveedor
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Registra una cotización para {{ $cotizacionConcepto->nombre }}.
                            </p>
                        </div>

                        <button
                            type="button"
                            onclick="closeCotizacionModal()"
                            class="text-2xl leading-none text-gray-400 hover:text-gray-600"
                        >
                            &times;
                        </button>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('proyectos.cotizaciones.detalles.store', [$proyecto, $cotizacionConcepto]) }}"
                        enctype="multipart/form-data"
                        class="space-y-4"
                    >
                        @csrf

                        <div>
                            <label for="proveedor" class="block text-sm font-medium text-gray-700">
                                Proveedor
                            </label>

                            <input
                                type="text"
                                id="proveedor"
                                name="proveedor"
                                value="{{ old('proveedor') }}"
                                required
                                maxlength="255"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error('proveedor')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="precio" class="block text-sm font-medium text-gray-700">
                                Precio
                            </label>

                            <input
                                type="number"
                                id="precio"
                                name="precio"
                                value="{{ old('precio') }}"
                                required
                                min="0.01"
                                step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error('precio')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="observaciones" class="block text-sm font-medium text-gray-700">
                                Observaciones
                            </label>

                            <textarea
                                id="observaciones"
                                name="observaciones"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >{{ old('observaciones') }}</textarea>

                            @error('observaciones')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="archivos" class="block text-sm font-medium text-gray-700">
                                Archivos
                            </label>

                            <input
                                type="file"
                                id="archivos"
                                name="archivos[]"
                                multiple
                                accept=".pdf,image/*"
                                class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                            >

                            @error('archivos')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @error('archivos.*')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button
                                type="button"
                                onclick="closeCotizacionModal()"
                                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                            >
                                Guardar cotización
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openCotizacionModal() {
                document.getElementById('cotizacionModal').classList.remove('hidden');
            }

            function closeCotizacionModal() {
                document.getElementById('cotizacionModal').classList.add('hidden');
            }

            @if ($errors->any())
                document.addEventListener('DOMContentLoaded', function () {
                    openCotizacionModal();
                });
            @endif
        </script>
    @endcan
</x-app-layout>
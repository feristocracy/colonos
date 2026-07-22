<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <a
                    href="{{ route('proyectos.show', $proyecto) }}"
                    class="group inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                    title="Volver al proyecto"
                >
                    <svg class="h-5 w-5 transition-transform group-hover:-translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-800">
                        Cotización: {{ $proyecto->nombre }}
                    </h2>
                    <p class="mt-1 flex items-center gap-1.5 text-sm font-medium text-violet-600">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        Concepto: {{ $cotizacionConcepto->nombre }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Concepto --}}
            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm ring-1 ring-gray-900/5 sm:p-8">
                <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-start">
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                            <svg class="h-5 w-5 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            Detalles del concepto
                        </h3>

                        @if ($cotizacionConcepto->descripcion)
                            <p class="mt-4 rounded-xl bg-gray-50 p-4 text-sm leading-relaxed text-gray-700">
                                {{ $cotizacionConcepto->descripcion }}
                            </p>
                        @endif

                        <div class="mt-4 flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-100 text-sm font-semibold text-violet-700">
                                {{ substr($cotizacionConcepto->creador->name, 0, 1) }}
                            </div>
                            <p class="text-sm text-gray-500">
                                Creado por <span class="font-medium text-gray-900">{{ $cotizacionConcepto->creador->name }}</span>
                                el {{ $cotizacionConcepto->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    @can('alimentar', $proyecto)
                        <button
                            type="button"
                            onclick="openCotizacionModal()"
                            class="inline-flex flex-shrink-0 items-center justify-center rounded-lg bg-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-violet-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                        >
                            <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Agregar proveedor
                        </button>
                    @endcan
                </div>
            </section>

            {{-- Cotizaciones --}}
            <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm ring-1 ring-gray-900/5">
                <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-5 sm:px-8">
                    <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                        <svg class="h-5 w-5 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                        Cotizaciones registradas
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Comparativa de proveedores, precios, observaciones y archivos adjuntos.
                    </p>
                </div>

                <div class="divide-y divide-gray-100 bg-gray-50/30 p-4 sm:p-6 space-y-6">
                    @forelse ($cotizaciones as $cotizacion)
                        <article class="rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md">
                            {{-- Cabecera del proveedor --}}
                            <div class="border-b border-gray-100 p-6 sm:p-8">
                                <div class="flex flex-col justify-between gap-6 md:flex-row md:items-start">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-4">
                                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-violet-100 text-xl font-bold text-violet-700 ring-1 ring-inset ring-violet-600/10">
                                                {{ substr($cotizacion->proveedor, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-bold text-gray-900">
                                                    {{ $cotizacion->proveedor }}
                                                </h4>
                                                @if ($cotizacion->telefono)
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        Tel. {{ $cotizacion->telefono }}
                                                    </p>
                                                @endif
                                                <p class="mt-1 flex items-center gap-1.5 text-xs text-gray-500">
                                                    <svg class="h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Registrada por {{ $cotizacion->usuario->name }} el {{ $cotizacion->created_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                            <div class="ml-auto md:ml-0">
                                                <span class="inline-flex items-center rounded-lg bg-emerald-50 px-4 py-2 text-xl font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                    ${{ number_format($cotizacion->precio, 2) }}
                                                </span>
                                            </div>
                                        </div>

                                        @if ($cotizacion->observaciones)
                                            <div class="mt-6">
                                                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Observaciones</p>
                                                <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4">
                                                    <p class="text-sm leading-relaxed text-gray-700">
                                                        {{ $cotizacion->observaciones }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Botones de acción del proveedor --}}
                                    <div class="flex flex-col gap-3 md:w-64 md:flex-shrink-0">
                                        @if (auth()->user()->role === 'admin')
                                            <button
                                                type="button"
                                                onclick="document.getElementById('archivosModal-{{ $cotizacion->id }}').classList.remove('hidden')"
                                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                            >
                                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                                </svg>
                                                Agregar archivos
                                            </button>

                                            <button
                                                type="button"
                                                onclick="document.getElementById('comentarioModal-{{ $cotizacion->id }}').classList.remove('hidden')"
                                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-violet-50 px-4 py-2.5 text-sm font-semibold text-violet-700 ring-1 ring-inset ring-violet-600/20 transition-colors hover:bg-violet-100 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                            >
                                                <svg class="h-4 w-4 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                                                </svg>
                                                Agregar comentario
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Sección de contenido inferior (Archivos y Comentarios) --}}
                            @if ($cotizacion->archivos->isNotEmpty() || $cotizacion->comentarios->isNotEmpty())
                                <div class=" gap-0 divide-gray-100 flex">
                                    {{-- Columna Comentarios --}}
                                    <div class="bg-gray-50/50 p-6 sm:p-8 w-3/4">
                                        <h5 class="mb-4 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                            </svg>
                                            Comentarios ({{ $cotizacion->comentarios->count() }})
                                        </h5>

                                        @if ($cotizacion->comentarios->isNotEmpty())
                                            <div class="space-y-4">
                                                @foreach ($cotizacion->comentarios as $comentario)
                                                    <div class="flex gap-3">
                                                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-violet-100 text-xs font-bold text-violet-700">
                                                            {{ substr($comentario->usuario->name, 0, 1) }}
                                                        </div>
                                                        <div class="flex-1 rounded-2xl rounded-tl-none border border-gray-200 bg-white p-4 shadow-sm">
                                                            <div class="flex items-center justify-between gap-2 border-b border-gray-100 pb-2 mb-2">
                                                                <span class="text-sm font-semibold text-gray-900">{{ $comentario->usuario->name }}</span>
                                                                <span class="text-[10px] text-gray-500">{{ $comentario->created_at->format('d/m/Y H:i') }}</span>
                                                            </div>
                                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $comentario->comentario }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 italic">No hay comentarios aún.</p>
                                        @endif
                                    </div>
                                    {{-- Columna Archivos --}}
                                    <div class="p-8 sm:p-8 w-1/4">
                                        <h5 class="mb-4 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                            </svg>
                                            Archivos adjuntos ({{ $cotizacion->archivos->count() }})
                                        </h5>

                                        @if ($cotizacion->archivos->isNotEmpty())
                                            <div class="space-y-3">
                                                @foreach ($cotizacion->archivos as $archivo)
                                                    <a
                                                        href="{{ \Illuminate\Support\Facades\Storage::url($archivo->archivo) }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="group flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white p-3 text-sm text-gray-700 shadow-sm transition-all hover:border-violet-300 hover:bg-violet-50 hover:text-violet-700 hover:shadow-md"
                                                    >
                                                        <div class="flex min-w-0 items-center gap-3">
                                                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500 group-hover:bg-violet-200 group-hover:text-violet-600 transition-colors">
                                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                                </svg>
                                                            </div>
                                                            <span class="truncate font-medium">
                                                                {{ $archivo->nombre_original }}
                                                            </span>
                                                        </div>

                                                        <svg class="h-4 w-4 flex-shrink-0 text-gray-400 group-hover:text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                        </svg>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 italic">No hay archivos adjuntos.</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if(auth()->user()->role === 'admin')
                                <div id="archivosModal-{{ $cotizacion->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                                    <div class="flex min-h-screen items-center justify-center px-4 py-6">
                                        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('archivosModal-{{ $cotizacion->id }}').classList.add('hidden')"></div>

                                        <div class="relative w-full max-w-lg transform rounded-2xl bg-white p-6 text-left shadow-xl transition-all sm:p-8">
                                            <div class="mb-5 flex items-start justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">Agregar archivos</h3>
                                                    <p class="mt-1 text-sm text-gray-500">Para la cotización de {{ $cotizacion->proveedor }}</p>
                                                </div>
                                                <button type="button" onclick="document.getElementById('archivosModal-{{ $cotizacion->id }}').classList.add('hidden')" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-violet-500">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>

                                            <form method="POST" action="{{ route('proyectos.cotizaciones.detalles.archivos.store', [$proyecto, $cotizacionConcepto, $cotizacion]) }}" enctype="multipart/form-data">
                                                @csrf

                                                <label class="block text-sm font-semibold text-gray-900">
                                                    Seleccionar archivos
                                                </label>

                                                <input type="file" name="archivos[]" multiple accept=".pdf,image/*" class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200">

                                                <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-5">
                                                    <button type="button" onclick="document.getElementById('archivosModal-{{ $cotizacion->id }}').classList.add('hidden')" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                                                        Guardar archivos
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div id="comentarioModal-{{ $cotizacion->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                                    <div class="flex min-h-screen items-center justify-center px-4 py-6">
                                        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('comentarioModal-{{ $cotizacion->id }}').classList.add('hidden')"></div>

                                        <div class="relative w-full max-w-lg transform rounded-2xl bg-white p-6 text-left shadow-xl transition-all sm:p-8">
                                            <div class="mb-5 flex items-start justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">Agregar comentario</h3>
                                                    <p class="mt-1 text-sm text-gray-500">Para la cotización de {{ $cotizacion->proveedor }}</p>
                                                </div>
                                                <button type="button" onclick="document.getElementById('comentarioModal-{{ $cotizacion->id }}').classList.add('hidden')" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-violet-500">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>

                                            <form method="POST" action="{{ route('proyectos.cotizaciones.detalles.comentarios.store', [$proyecto, $cotizacionConcepto, $cotizacion]) }}">
                                                @csrf

                                                <label class="block text-sm font-semibold text-gray-900">
                                                    Comentario
                                                </label>

                                                <textarea name="comentario" rows="4" required placeholder="Escribe tu comentario u observación..." class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"></textarea>

                                                <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-5">
                                                    <button type="button" onclick="document.getElementById('comentarioModal-{{ $cotizacion->id }}').classList.add('hidden')" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
                                                        Guardar comentario
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </article>

                    @empty
                        <div class="px-6 py-16 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <h3 class="mt-4 text-sm font-semibold text-gray-900">No hay cotizaciones</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Aún no hay cotizaciones registradas para este concepto.
                            </p>
                        </div>
                    @endforelse
                </div>

                @if ($cotizaciones->hasPages())
                    <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4">
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
                    class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                    onclick="closeCotizacionModal()"
                ></div>

                <div class="relative w-full max-w-2xl transform rounded-2xl bg-white p-6 text-left shadow-xl transition-all sm:p-8">
                    <div class="mb-5 flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Agregar cotización de proveedor
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Registra una cotización para {{ $cotizacionConcepto->nombre }}.
                            </p>
                        </div>

                        <button
                            type="button"
                            onclick="closeCotizacionModal()"
                            class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-violet-500"
                        >
                            <span class="sr-only">Cerrar</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('proyectos.cotizaciones.detalles.store', [$proyecto, $cotizacionConcepto]) }}"
                        enctype="multipart/form-data"
                        class="space-y-5"
                    >
                        @csrf

                        <div>
                            <label for="proveedor" class="block text-sm font-semibold text-gray-900">
                                Proveedor / Empresa
                            </label>

                            <input
                                type="text"
                                id="proveedor"
                                name="proveedor"
                                value="{{ old('proveedor') }}"
                                required
                                maxlength="255"
                                placeholder="Ej. Home Depot, Herrería Pérez..."
                                class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                            >

                            @error('proveedor')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700">
                                Teléfono
                            </label>

                            <input
                                type="text"
                                id="telefono"
                                name="telefono"
                                value="{{ old('telefono') }}"
                                maxlength="30"
                                placeholder="Ej. 222 123 4567"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                            @error('telefono')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="precio" class="block text-sm font-semibold text-gray-900">
                                Precio cotizado
                            </label>

                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input
                                    type="number"
                                    id="precio"
                                    name="precio"
                                    value="{{ old('precio') }}"
                                    required
                                    min="0.01"
                                    step="0.01"
                                    placeholder="0.00"
                                    class="block w-full rounded-lg border-gray-300 py-2.5 pl-9 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                >
                            </div>

                            @error('precio')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="observaciones" class="block text-sm font-semibold text-gray-900">
                                Observaciones
                            </label>

                            <textarea
                                id="observaciones"
                                name="observaciones"
                                rows="3"
                                placeholder="Tiempos de entrega, condiciones, garantías..."
                                class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                            >{{ old('observaciones') }}</textarea>

                            @error('observaciones')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="archivos" class="block text-sm font-semibold text-gray-900">
                                Archivos adjuntos (Cotización formal, fotos)
                            </label>

                            <input
                                type="file"
                                id="archivos"
                                name="archivos[]"
                                multiple
                                accept=".pdf,image/*"
                                class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                            >

                            @error('archivos')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @error('archivos.*')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-5 border-t border-gray-100">
                            <button
                                type="button"
                                onclick="closeCotizacionModal()"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="rounded-lg bg-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
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

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a
                href="{{ route('proyectos.index') }}"
                class="group inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                title="Regresar a Proyectos"
            >
                <svg class="h-5 w-5 transition-transform group-hover:-translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>

            <h2 class="text-2xl font-bold tracking-tight text-gray-800">
                {{ $proyecto->nombre }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
                    <svg class="h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">
                    <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm ring-1 ring-gray-900/5 sm:p-8 lg:col-span-2">
                    <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                        <svg class="h-5 w-5 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Información del proyecto
                    </h3>

                    <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-gray-600">
                        {{ $proyecto->descripcion }}
                    </p>

                    <dl class="mt-8 grid gap-6 border-t border-gray-100 pt-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Creado por
                            </dt>
                            <dd class="mt-2 flex items-center gap-2 text-sm font-medium text-gray-900">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-100 text-violet-700">
                                    {{ substr($proyecto->creador->name, 0, 1) }}
                                </div>
                                {{ $proyecto->creador->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Fecha de creación
                            </dt>
                            <dd class="mt-2 flex items-center gap-2 text-sm font-medium text-gray-900">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                {{ $proyecto->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                    <div class="relative overflow-hidden rounded-2xl border border-violet-100 bg-violet-50 p-6 sm:p-8">
                        <div class="absolute -right-6 -top-6 text-violet-500/10">
                            <svg class="h-32 w-32" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                        </div>
                        <div class="relative">
                            <p class="text-sm font-semibold tracking-wide text-violet-700 uppercase">
                                Monto inicial
                            </p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-violet-900">
                                ${{ number_format($proyecto->monto_inicial, 2) }}
                            </p>
                        </div>
                    </div>

                    <div class="relative overflow-hidden rounded-2xl border border-emerald-100 bg-emerald-50 p-6 sm:p-8">
                        <div class="absolute -right-6 -top-6 text-emerald-500/10">
                            <svg class="h-32 w-32" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                            </svg>
                        </div>
                        <div class="relative">
                            <p class="text-sm font-semibold tracking-wide text-emerald-700 uppercase">
                                Saldo actual
                            </p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-emerald-900">
                                ${{ number_format($proyecto->saldo_actual, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                {{-- Líderes --}}
                <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm ring-1 ring-gray-900/5 sm:p-8">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row">
                        <div>
                            <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#7c3aed"><path d="M80-40v-80h800v80H80Zm80-120v-240q-33-54-51-114.5T91-638q0-61 15.5-120T143-874q8-21 26-33.5t40-12.5q31 0 53 21t18 50l-11 91q-6 48 8.5 91t43.5 75.5q29 32.5 70 52t89 19.5q60 0 120.5 12.5T706-472q45 23 69.5 58.5T800-326v166H160Zm80-80h480v-86q0-24-12-42.5T674-398q-41-20-95-31t-99-11q-66 0-122.5-27t-96-72.5Q222-585 202-644.5T190-768q-10 30-14.5 64t-4.5 66q0 58 20.5 111.5T240-422v182Zm127-367q-47-47-47-113t47-113q47-47 113-47t113 47q47 47 47 113t-47 113q-47 47-113 47t-113-47Zm169.5-56.5Q560-687 560-720t-23.5-56.5Q513-800 480-800t-56.5 23.5Q400-753 400-720t23.5 56.5Q447-640 480-640t56.5-23.5ZM320-160v-37q0-67 46.5-115T480-360h160v80H480q-34 0-57 24.5T400-197v37h-80Zm160-80Zm0-480Z"/></svg>
                                Líderes del proyecto
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Son los usuarios autorizados para alimentar la información.
                            </p>
                        </div>

                        @can('alimentar', $proyecto)
                            <span class="self-start inline-flex items-center rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-800 ring-1 ring-inset ring-violet-600/20">
                                Eres líder de este proyecto
                            </span>
                        @endcan
                    </div>

                    <div class="mt-6 space-y-3">
                        @foreach ($proyecto->lideres as $lider)
                            <div class="flex items-center justify-between rounded-xl border border-gray-100 px-4 py-3 transition-colors hover:bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600">
                                        {{ substr($lider->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            {{ $lider->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $lider->email }}
                                        </p>
                                    </div>
                                </div>

                                @can('gestionarLideres', $proyecto)
                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'proyectos.lideres.destroy',
                                            [$proyecto, $lider]
                                        ) }}"
                                        onsubmit="return confirm(
                                            '¿Deseas retirar a este líder del proyecto?'
                                        )"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                            title="Retirar líder"
                                        >
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endforeach
                    </div>

                    @can('gestionarLideres', $proyecto)
                        @if ($usuariosDisponibles->isNotEmpty())
                            <form
                                method="POST"
                                action="{{ route('proyectos.lideres.store', $proyecto) }}"
                                class="mt-6 flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row"
                            >
                                @csrf

                                <div class="flex-1">
                                    <label for="user_id" class="sr-only">
                                        Usuario
                                    </label>

                                    <select
                                        id="user_id"
                                        name="user_id"
                                        required
                                        class="block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                    >
                                        <option value="">Selecciona un usuario para agregar</option>

                                        @foreach ($usuariosDisponibles as $usuario)
                                            <option value="{{ $usuario->id }}">
                                                {{ $usuario->name }} — {{ $usuario->email }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('user_id')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-violet-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                >
                                    Agregar
                                </button>
                            </form>
                        @endif
                    @endcan
                </section>

                {{-- Cotizaciones --}}
                <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm ring-1 ring-gray-900/5 sm:p-8">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#7c3aed"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm221.5-198.5Q510-807 510-820t-8.5-21.5Q493-850 480-850t-21.5 8.5Q450-833 450-820t8.5 21.5Q467-790 480-790t21.5-8.5ZM200-200v-560 560Z"/></svg>
                                Cotizaciones
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Conceptos y comparativas de precios.
                            </p>
                        </div>

                        @can('alimentar', $proyecto)
                            <button
                                type="button"
                                onclick="openCotizacionConceptoModal()"
                                class="inline-flex items-center justify-center rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-violet-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                            >
                                <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Agregar
                            </button>
                        @endcan
                    </div>

                    <div class="mt-6 space-y-3">
                        @forelse ($cotizacionConceptos as $cotizacionConcepto)
                            <div class="flex flex-col justify-between gap-4 rounded-xl border border-gray-100 px-5 py-4 transition-colors hover:bg-violet-50/50 sm:flex-row sm:items-center">
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $cotizacionConcepto->nombre }}
                                    </p>

                                    @if ($cotizacionConcepto->descripcion)
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ Str::limit($cotizacionConcepto->descripcion, 60) }}
                                        </p>
                                    @endif

                                    <div class="mt-2 flex items-center gap-1.5 text-xs text-gray-500">
                                        <svg class="h-3.5 w-3.5 text-violet-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $cotizacionConcepto->cotizaciones_count }} cotización(es)
                                    </div>
                                </div>

                                <a
                                    href="{{ route('proyectos.cotizaciones.show', [$proyecto, $cotizacionConcepto]) }}"
                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition-all hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                >
                                    Ver detalles
                                </a>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-gray-300 px-4 py-10 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">
                                    Aún no hay conceptos de cotización registrados.
                                </p>
                            </div>
                        @endempty
                    </div>
                </section>
                @can('alimentar', $proyecto)
                    <div
                        id="cotizacionConceptoModal"
                        class="fixed inset-0 z-50 hidden overflow-y-auto"
                        aria-labelledby="cotizacionConceptoModalTitle"
                        role="dialog"
                        aria-modal="true"
                    >
                        <div class="flex min-h-screen items-center justify-center px-4 py-6">
                            <div
                                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                                onclick="closeCotizacionConceptoModal()"
                            ></div>

                            <div class="relative w-full max-w-lg transform rounded-2xl bg-white p-6 text-left shadow-xl transition-all sm:p-8">
                                <div class="mb-5 flex items-start justify-between">
                                    <div>
                                        <h3
                                            id="cotizacionConceptoModalTitle"
                                            class="text-lg font-semibold text-gray-900"
                                        >
                                            Agregar concepto de cotización
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Registra el concepto que se va a cotizar.
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        onclick="closeCotizacionConceptoModal()"
                                        class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-violet-500"
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('proyectos.cotizaciones.store', $proyecto) }}"
                                    class="space-y-5"
                                >
                                    @csrf

                                    <div>
                                        <label for="cotizacion_nombre" class="block text-sm font-semibold text-gray-900">
                                            Nombre
                                        </label>

                                        <input
                                            type="text"
                                            id="cotizacion_nombre"
                                            name="nombre"
                                            value="{{ old('nombre') }}"
                                            required
                                            maxlength="255"
                                            placeholder="Ej. Malla ciclónica"
                                            class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                        >

                                        @error('nombre')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="cotizacion_descripcion" class="block text-sm font-semibold text-gray-900">
                                            Descripción
                                        </label>

                                        <textarea
                                            id="cotizacion_descripcion"
                                            name="descripcion"
                                            rows="3"
                                            placeholder="Describe brevemente qué se quiere comprar, instalar o contratar."
                                            class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                        >{{ old('descripcion') }}</textarea>

                                        @error('descripcion')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                        <button
                                            type="button"
                                            onclick="closeCotizacionConceptoModal()"
                                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                        >
                                            Cancelar
                                        </button>

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                        >
                                            Guardar y continuar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function openCotizacionConceptoModal() {
                            document.getElementById('cotizacionConceptoModal').classList.remove('hidden');
                        }

                        function closeCotizacionConceptoModal() {
                            document.getElementById('cotizacionConceptoModal').classList.add('hidden');
                        }

                        @if ($errors->has('nombre') || $errors->has('descripcion'))
                            document.addEventListener('DOMContentLoaded', function () {
                                openCotizacionConceptoModal();
                            });
                        @endif
                    </script>
                @endcan
            </div>

            {{-- Movimientos --}}
            <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm ring-1 ring-gray-900/5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 px-6 py-6 sm:px-8 gap-4">
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                            <svg class="h-5 w-5 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Entradas y salidas
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Historial financiero detallado del proyecto.
                        </p>
                    </div>

                    {{-- Modal para registrar movimiento --}}
                    @can('alimentar', $proyecto)
                        <div class="flex flex-wrap items-center gap-3">
                            <button
                                type="button"
                                onclick="openMovimientoModal('entrada')"
                                class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-emerald-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                            >
                                <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                                </svg>
                                Registrar entrada
                            </button>

                            <button
                                type="button"
                                onclick="openMovimientoModal('salida')"
                                class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-red-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                            >
                                <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6.75 9.25a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                                </svg>
                                Registrar salida
                            </button>
                        </div>

                        <div
                            id="movimientoModal"
                            class="fixed inset-0 z-50 hidden overflow-y-auto"
                            aria-labelledby="movimientoModalTitle"
                            role="dialog"
                            aria-modal="true"
                        >
                            <div class="flex min-h-screen items-center justify-center px-4 py-6">
                                <div
                                    class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                                    onclick="closeMovimientoModal()"
                                ></div>

                                <div class="relative w-full max-w-lg transform rounded-2xl bg-white p-6 text-left shadow-xl transition-all sm:p-8">
                                    <div class="flex items-start justify-between mb-5">
                                        <div>
                                            <h3
                                                id="movimientoModalTitle"
                                                class="text-lg font-semibold text-gray-900"
                                            >
                                                Registrar movimiento
                                            </h3>
                                            <p id="movimientoModalSubtitle" class="mt-1 text-sm text-gray-500">
                                                Captura los datos del movimiento.
                                            </p>
                                        </div>

                                        <button
                                            type="button"
                                            onclick="closeMovimientoModal()"
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
                                        action="{{ route('proyectos.movimientos.store', $proyecto) }}"
                                        enctype="multipart/form-data"
                                        class="space-y-5"
                                    >
                                        @csrf

                                        <input type="hidden" name="tipo" id="movimientoTipo" value="{{ old('tipo', 'entrada') }}">

                                        <div>
                                            <label for="concepto" class="block text-sm font-semibold text-gray-900">
                                                Concepto
                                            </label>
                                            <input
                                                type="text"
                                                name="concepto"
                                                id="concepto"
                                                value="{{ old('concepto') }}"
                                                required
                                                maxlength="255"
                                                class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                                placeholder="Ej. Compra de material"
                                            >
                                            @error('concepto')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="monto" class="block text-sm font-semibold text-gray-900">
                                                Cantidad
                                            </label>
                                            <div class="relative mt-2">
                                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                                    <span class="text-gray-500 sm:text-sm">$</span>
                                                </div>
                                                <input
                                                    type="number"
                                                    name="monto"
                                                    id="monto"
                                                    value="{{ old('monto') }}"
                                                    required
                                                    min="0.01"
                                                    step="0.01"
                                                    class="block w-full rounded-lg border-gray-300 py-2.5 pl-9 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                                    placeholder="0.00"
                                                >
                                            </div>
                                            <p class="mt-2 flex items-center gap-1.5 text-xs text-gray-500">
                                                <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Saldo actual disponible: <span class="font-medium text-gray-900">${{ number_format($proyecto->saldo_actual, 2) }}</span>
                                            </p>
                                            @error('monto')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="descripcion" class="block text-sm font-semibold text-gray-900">
                                                Descripción
                                            </label>
                                            <textarea
                                                name="descripcion"
                                                id="descripcion"
                                                rows="3"
                                                class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                                placeholder="Describe brevemente el motivo del movimiento"
                                            >{{ old('descripcion') }}</textarea>
                                            @error('descripcion')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="comprobante" class="block text-sm font-semibold text-gray-900">
                                                Foto / comprobante
                                            </label>
                                            <input
                                                type="file"
                                                name="comprobante"
                                                id="comprobante"
                                                accept="image/*"
                                                class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                                            >
                                            @error('comprobante')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end gap-3 pt-5 border-t border-gray-100">
                                            <button
                                                type="button"
                                                onclick="closeMovimientoModal()"
                                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                            >
                                                Cancelar
                                            </button>

                                            <button
                                                type="submit"
                                                id="movimientoSubmitButton"
                                                class="rounded-lg px-4 py-2.5 text-sm font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2"
                                            >
                                                Registrar entrada
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            function openMovimientoModal(tipo) {
                                const modal = document.getElementById('movimientoModal');
                                const tipoInput = document.getElementById('movimientoTipo');
                                const title = document.getElementById('movimientoModalTitle');
                                const subtitle = document.getElementById('movimientoModalSubtitle');
                                const submitButton = document.getElementById('movimientoSubmitButton');

                                tipoInput.value = tipo;

                                if (tipo === 'entrada') {
                                    title.textContent = 'Registrar entrada';
                                    subtitle.textContent = 'Registra una entrada de dinero al proyecto.';
                                    submitButton.textContent = 'Registrar entrada';
                                    submitButton.className = 'rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2';
                                } else {
                                    title.textContent = 'Registrar salida';
                                    subtitle.textContent = 'Registra una salida de dinero del proyecto.';
                                    submitButton.textContent = 'Registrar salida';
                                    submitButton.className = 'rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2';
                                }

                                modal.classList.remove('hidden');
                            }

                            function closeMovimientoModal() {
                                document.getElementById('movimientoModal').classList.add('hidden');
                            }

                            document.addEventListener('keydown', function (event) {
                                if (event.key === 'Escape') {
                                    closeMovimientoModal();
                                }
                            });
                            @if ($errors->any() && old('tipo'))
                                document.addEventListener('DOMContentLoaded', function () {
                                    openMovimientoModal('{{ old('tipo') }}');
                                });
                            @endif
                        </script>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Fecha
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Concepto
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Registrado por
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Tipo
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Monto
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Evidencia
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($movimientos as $movimiento)
                                <tr class="transition-colors hover:bg-gray-50/50">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                        {{ $movimiento->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $movimiento->concepto }}
                                        </p>

                                        @if ($movimiento->descripcion)
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $movimiento->descripcion }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 text-xs font-medium text-gray-600">
                                                {{ substr($movimiento->usuario->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $movimiento->usuario->name }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span @class([
                                            'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset',
                                            'bg-violet-50 text-violet-700 ring-violet-600/20' =>
                                                $movimiento->tipo === 'saldo_inicial',
                                            'bg-emerald-50 text-emerald-700 ring-emerald-600/20' =>
                                                $movimiento->tipo === 'entrada',
                                            'bg-red-50 text-red-700 ring-red-600/10' =>
                                                $movimiento->tipo === 'salida',
                                        ])>
                                            {{ match ($movimiento->tipo) {
                                                'saldo_inicial' => 'Saldo inicial',
                                                'entrada' => 'Entrada',
                                                'salida' => 'Salida',
                                            } }}
                                        </span>
                                    </td>

                                    <td @class([
                                        'whitespace-nowrap px-6 py-4 text-right font-semibold',
                                        'text-red-600' =>
                                            $movimiento->tipo === 'salida',
                                        'text-emerald-700' =>
                                            $movimiento->tipo !== 'salida',
                                    ])>
                                        {{ $movimiento->tipo === 'salida' ? '−' : '+' }}
                                        ${{ number_format($movimiento->monto, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($movimiento->comprobante)
                                            <a
                                                href="{{ Storage::url($movimiento->comprobante) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center rounded-lg bg-gray-50 p-2 text-gray-500 ring-1 ring-inset ring-gray-300 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                                                title="Ver comprobante"
                                            >
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($movimientos->hasPages())
                    <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4">
                        {{ $movimientos->links() }}
                    </div>
                @endif
            </section>

            {{-- Notas --}}
            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm ring-1 ring-gray-900/5 sm:p-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                            <svg class="h-5 w-5 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Notas
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Avances, evidencias, noticias y datos importantes del proyecto.
                        </p>
                    </div>

                    @can('alimentar', $proyecto)
                        <button
                            type="button"
                            onclick="openNotaModal()"
                            class="inline-flex items-center justify-center rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-violet-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                        >
                            <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Agregar nota
                        </button>
                    @endcan
                </div>

                <div class="mt-8 space-y-6">
                    @forelse ($notas as $nota)
                        <article class="relative rounded-2xl border border-gray-100 bg-white p-5 shadow-sm ring-1 ring-gray-900/5 transition-shadow hover:shadow-md">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-100 text-violet-700">
                                        <span class="font-semibold">{{ substr($nota->usuario->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $nota->usuario->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $nota->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 rounded-xl bg-gray-50 p-4">
                                <p class="whitespace-pre-line text-sm text-gray-700">
                                    {{ $nota->comentario }}
                                </p>
                            </div>

                            @if ($nota->archivos->isNotEmpty())
                                <div class="mt-4 border-t border-gray-100 pt-4">
                                    <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        Archivos adjuntos
                                    </p>

                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($nota->archivos as $archivo)
                                            <a
                                                href="{{ \Illuminate\Support\Facades\Storage::url($archivo->archivo) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="group inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm transition-all hover:border-violet-300 hover:bg-violet-50 hover:text-violet-700"
                                            >
                                                <svg class="h-4 w-4 text-gray-400 group-hover:text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                                                </svg>
                                                <span class="truncate max-w-[200px]">{{ $archivo->nombre_original }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </article>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-300 px-4 py-12 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">
                                Aún no hay notas registradas para este proyecto.
                            </p>
                        </div>
                    @endforelse
                </div>

                @if ($notas->hasPages())
                    <div class="mt-8 border-t border-gray-100 pt-6">
                        {{ $notas->links() }}
                    </div>
                @endif

                @can('alimentar', $proyecto)
                    <div
                        id="notaModal"
                        class="fixed inset-0 z-50 hidden overflow-y-auto"
                        role="dialog"
                        aria-modal="true"
                    >
                        <div class="flex min-h-screen items-center justify-center px-4 py-6">
                            <div
                                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                                onclick="closeNotaModal()"
                            ></div>

                            <div class="relative w-full max-w-2xl transform rounded-2xl bg-white p-6 text-left shadow-xl transition-all sm:p-8">
                                <div class="mb-5 flex items-start justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Agregar nota
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Registra un avance, noticia, evidencia o dato importante del proyecto.
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        onclick="closeNotaModal()"
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
                                    action="{{ route('proyectos.notas.store', $proyecto) }}"
                                    enctype="multipart/form-data"
                                    class="space-y-5"
                                >
                                    @csrf

                                    <div>
                                        <label for="comentario" class="block text-sm font-semibold text-gray-900">
                                            Nota
                                        </label>

                                        <textarea
                                            id="comentario"
                                            name="comentario"
                                            rows="5"
                                            required
                                            placeholder="Ej. Se terminó la limpieza del área norte del parque..."
                                            class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 text-gray-900 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                        >{{ old('comentario') }}</textarea>

                                        @error('comentario')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="nota_archivos" class="block text-sm font-semibold text-gray-900">
                                            Archivos
                                        </label>

                                        <input
                                            type="file"
                                            id="nota_archivos"
                                            name="archivos[]"
                                            multiple
                                            accept=".pdf,.doc,.docx,.xls,.xlsx,image/*"
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
                                            onclick="closeNotaModal()"
                                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                        >
                                            Cancelar
                                        </button>

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                        >
                                            Guardar nota
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function openNotaModal() {
                            document.getElementById('notaModal').classList.remove('hidden');
                        }

                        function closeNotaModal() {
                            document.getElementById('notaModal').classList.add('hidden');
                        }

                        @if ($errors->has('comentario') || $errors->has('archivos') || $errors->has('archivos.*'))
                            document.addEventListener('DOMContentLoaded', function () {
                                openNotaModal();
                            });
                        @endif
                    </script>
                @endcan
            </section>

            {{-- Auditoría --}}
            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm ring-1 ring-gray-900/5 sm:p-8">
                <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900">
                    <svg class="h-5 w-5 text-violet-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Auditoría
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Historial de acciones realizadas dentro del proyecto.
                </p>

                <div class="mt-8 flow-root">
                    <ul class="-mb-8">
                        @foreach ($auditorias as $auditoria)
                            <li>
                                <div class="relative pb-8">
                                    @unless ($loop->last)
                                        <span class="absolute left-4 top-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endunless

                                    <div class="relative flex items-start gap-4">
                                        <div class="relative flex h-8 w-8 items-center justify-center rounded-full bg-violet-100 ring-8 ring-white">
                                            <svg class="h-4 w-4 text-violet-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>

                                        <div class="min-w-0 flex-1 pt-1.5">
                                            <div class="text-sm text-gray-700">
                                                <span class="font-semibold text-gray-900">
                                                    {{ $auditoria->usuario?->name ?? 'Sistema' }}
                                                </span>
                                                <span class="text-gray-600">
                                                    {{ $auditoria->descripcion }}
                                                </span>
                                            </div>

                                            <div class="mt-1 flex items-center gap-2 text-xs text-gray-500">
                                                <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                                </svg>
                                                {{ $auditoria->created_at->format('d/m/Y - H:i:s') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if ($auditorias->hasPages())
                    <div class="mt-8 border-t border-gray-100 pt-6">
                        {{ $auditorias->links() }}
                    </div>
                @endif
            </section>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a
                href="{{ route('proyectos.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-gray-800"
            >
                ← Proyectos
            </a>

            <h2 class="text-xl font-semibold text-gray-800">
                {{ $proyecto->nombre }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50
                            px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-lg border border-red-200 bg-red-50
                            px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-xl border border-gray-200 bg-white p-6
                            shadow-sm lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Información del proyecto
                    </h3>

                    <p class="mt-4 whitespace-pre-line text-sm leading-6
                              text-gray-600">{{ $proyecto->descripcion }}</p>

                    <dl class="mt-6 grid gap-4 border-t border-gray-200 pt-5
                               sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase
                                       tracking-wide text-gray-500">
                                Creado por
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $proyecto->creador->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase
                                       tracking-wide text-gray-500">
                                Fecha de creación
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $proyecto->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                    <div class="rounded-xl border border-blue-200 bg-blue-50 p-6">
                        <p class="text-sm font-medium text-blue-700">
                            Monto inicial
                        </p>
                        <p class="mt-2 text-3xl font-bold text-blue-900">
                            ${{ number_format($proyecto->monto_inicial, 2) }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-green-200 bg-green-50 p-6">
                        <p class="text-sm font-medium text-green-700">
                            Saldo actual
                        </p>
                        <p class="mt-2 text-3xl font-bold text-green-900">
                            ${{ number_format($proyecto->saldo_actual, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                {{-- Líderes --}}
                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Líderes del proyecto
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Son los usuarios autorizados para alimentar la información.
                            </p>
                        </div>

                        @can('alimentar', $proyecto)
                            <span class="self-start rounded-full bg-green-100 px-3 py-1
                                        text-xs font-semibold text-green-700">
                                Eres líder de este proyecto
                            </span>
                        @endcan
                    </div>

                    <div class="mt-5 space-y-3">
                        @foreach ($proyecto->lideres as $lider)
                            <div class="flex items-center justify-between rounded-lg
                                        border border-gray-200 px-4 py-3">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $lider->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $lider->email }}
                                    </p>
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
                                            class="text-sm font-semibold text-red-600
                                                hover:text-red-800"
                                        >
                                            Retirar
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
                                class="mt-6 flex flex-col gap-3 border-t
                                    border-gray-200 pt-5 sm:flex-row"
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
                                        class="block w-full rounded-md border-gray-300
                                            shadow-sm focus:border-blue-500
                                            focus:ring-blue-500"
                                    >
                                        <option value="">Selecciona un usuario</option>

                                        @foreach ($usuariosDisponibles as $usuario)
                                            <option value="{{ $usuario->id }}">
                                                {{ $usuario->name }}
                                                — {{ $usuario->email }}
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
                                    class="rounded-md bg-blue-600 px-4 py-2 text-sm
                                        font-semibold text-white hover:bg-blue-700"
                                >
                                    Agregar líder
                                </button>
                            </form>
                        @endif
                    @endcan
                </section>

                {{-- Cotizaciones --}}
<!--                 <section>
                    <h3 class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm text-lg font-semibold text-gray-900">
                        Cotizaciones
                    </h3>
                </section> -->
                <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Cotizaciones
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Conceptos y comparativas de precios para transparentar decisiones del proyecto.
                            </p>
                        </div>

                        @can('alimentar', $proyecto)
                            <button
                                type="button"
                                onclick="openCotizacionConceptoModal()"
                                class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                            >
                                Agregar cotización
                            </button>
                        @endcan
                    </div>

                    <div class="mt-6 space-y-3">
                        @forelse ($cotizacionConceptos as $cotizacionConcepto)
                            <div class="flex flex-col justify-between gap-4 rounded-lg border border-gray-200 px-4 py-4 sm:flex-row sm:items-center">
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $cotizacionConcepto->nombre }}
                                    </p>

                                    @if ($cotizacionConcepto->descripcion)
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $cotizacionConcepto->descripcion }}
                                        </p>
                                    @endif

                                    <p class="mt-2 text-xs text-gray-400">
                                        {{ $cotizacionConcepto->cotizaciones_count }} cotización(es) registrada(s)
                                    </p>
                                </div>

                                <a
                                    href="{{ route('proyectos.cotizaciones.show', [$proyecto, $cotizacionConcepto]) }}"
                                    class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                                >
                                    Ver detalles
                                </a>
                            </div>
                        @empty
                            <div class="rounded-lg border border-dashed border-gray-300 px-4 py-8 text-center">
                                <p class="text-sm text-gray-500">
                                    Aún no hay conceptos de cotización registrados.
                                </p>
                            </div>
                        @endforelse
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
                                class="fixed inset-0 bg-gray-900 bg-opacity-50"
                                onclick="closeCotizacionConceptoModal()"
                            ></div>

                            <div class="relative w-full max-w-lg rounded-lg bg-white p-6 shadow-xl">
                                <div class="mb-5 flex items-start justify-between">
                                    <div>
                                        <h3
                                            id="cotizacionConceptoModalTitle"
                                            class="text-lg font-semibold text-gray-900"
                                        >
                                            Agregar cotización
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Registra el concepto que se va a cotizar.
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        onclick="closeCotizacionConceptoModal()"
                                        class="text-2xl leading-none text-gray-400 hover:text-gray-600"
                                    >
                                        &times;
                                    </button>
                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('proyectos.cotizaciones.store', $proyecto) }}"
                                    class="space-y-4"
                                >
                                    @csrf

                                    <div>
                                        <label for="cotizacion_nombre" class="block text-sm font-medium text-gray-700">
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
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        >

                                        @error('nombre')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="cotizacion_descripcion" class="block text-sm font-medium text-gray-700">
                                            Descripción
                                        </label>

                                        <textarea
                                            id="cotizacion_descripcion"
                                            name="descripcion"
                                            rows="3"
                                            placeholder="Describe brevemente qué se quiere comprar, instalar o contratar."
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        >{{ old('descripcion') }}</textarea>

                                        @error('descripcion')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end gap-3 pt-4">
                                        <button
                                            type="button"
                                            onclick="closeCotizacionConceptoModal()"
                                            class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                                        >
                                            Cancelar
                                        </button>

                                        <button
                                            type="submit"
                                            class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
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
            <section class="overflow-hidden rounded-xl border border-gray-200
                            bg-white shadow-sm">
                <div class="flex items-center justify-between border-b
                            border-gray-200 px-6 py-5">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Entradas y salidas
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Historial financiero del proyecto.
                        </p>
                    </div>

                    {{-- Modal para registrar movimiento --}}
                    @can('alimentar', $proyecto)
                        <div class="flex flex-wrap items-center gap-3 mb-6">
                            <button
                                type="button"
                                onclick="openMovimientoModal('entrada')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition"
                            >
                                Ingresar dinero
                            </button>

                            <button
                                type="button"
                                onclick="openMovimientoModal('salida')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
                            >
                                Sacar dinero
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
                                    class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"
                                    onclick="closeMovimientoModal()"
                                ></div>

                                <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h3
                                                id="movimientoModalTitle"
                                                class="text-lg font-semibold text-gray-900"
                                            >
                                                Registrar movimiento
                                            </h3>
                                            <p id="movimientoModalSubtitle" class="text-sm text-gray-500 mt-1">
                                                Captura los datos del movimiento.
                                            </p>
                                        </div>

                                        <button
                                            type="button"
                                            onclick="closeMovimientoModal()"
                                            class="text-gray-400 hover:text-gray-600"
                                        >
                                            <span class="sr-only">Cerrar</span>
                                            &times;
                                        </button>
                                    </div>

                                    <form
                                        method="POST"
                                        action="{{ route('proyectos.movimientos.store', $proyecto) }}"
                                        enctype="multipart/form-data"
                                        class="space-y-4"
                                    >
                                        @csrf

                                        <input type="hidden" name="tipo" id="movimientoTipo" value="{{ old('tipo', 'entrada') }}">

                                        <div>
                                            <label for="concepto" class="block text-sm font-medium text-gray-700">
                                                Concepto
                                            </label>
                                            <input
                                                type="text"
                                                name="concepto"
                                                id="concepto"
                                                value="{{ old('concepto') }}"
                                                required
                                                maxlength="255"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="Ej. Compra de material"
                                            >
                                            @error('concepto')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="monto" class="block text-sm font-medium text-gray-700">
                                                Cantidad
                                            </label>
                                            <p class="mt-1 text-sm text-gray-500">
                                                Saldo actual disponible: ${{ number_format($proyecto->saldo_actual, 2) }}
                                            </p>
                                            <input
                                                type="number"
                                                name="monto"
                                                id="monto"
                                                value="{{ old('monto') }}"
                                                required
                                                min="0.01"
                                                step="0.01"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="0.00"
                                            >
                                            @error('monto')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="descripcion" class="block text-sm font-medium text-gray-700">
                                                Descripción
                                            </label>
                                            <textarea
                                                name="descripcion"
                                                id="descripcion"
                                                rows="3"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="Describe brevemente el motivo del movimiento"
                                            >{{ old('descripcion') }}</textarea>
                                            @error('descripcion')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="comprobante" class="block text-sm font-medium text-gray-700">
                                                Foto / comprobante
                                            </label>
                                            <input
                                                type="file"
                                                name="comprobante"
                                                id="comprobante"
                                                accept="image/*"
                                                class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                                            >
                                            @error('comprobante')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end gap-3 pt-4">
                                            <button
                                                type="button"
                                                onclick="closeMovimientoModal()"
                                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50"
                                            >
                                                Cancelar
                                            </button>

                                            <button
                                                type="submit"
                                                id="movimientoSubmitButton"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700"
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
                                    title.textContent = 'Ingresar dinero';
                                    subtitle.textContent = 'Registra una entrada de dinero al proyecto.';
                                    submitButton.textContent = 'Registrar entrada';
                                    submitButton.classList.remove('bg-red-600', 'hover:bg-red-700');
                                    submitButton.classList.add('bg-green-600', 'hover:bg-green-700');
                                } else {
                                    title.textContent = 'Sacar dinero';
                                    subtitle.textContent = 'Registra una salida de dinero del proyecto.';
                                    submitButton.textContent = 'Registrar salida';
                                    submitButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                                    submitButton.classList.add('bg-red-600', 'hover:bg-red-700');
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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold
                                           uppercase text-gray-500">
                                    Fecha
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold
                                           uppercase text-gray-500">
                                    Concepto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold
                                           uppercase text-gray-500">
                                    Registrado por
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold
                                           uppercase text-gray-500">
                                    Tipo
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold
                                           uppercase text-gray-500">
                                    Monto
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold
                                           uppercase text-gray-500">
                                    Ver
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @foreach ($movimientos as $movimiento)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm
                                               text-gray-600">
                                        {{ $movimiento->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $movimiento->concepto }}
                                        </p>

                                        @if ($movimiento->descripcion)
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $movimiento->descripcion }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $movimiento->usuario->name }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span @class([
                                            'rounded-full px-2.5 py-1 text-xs font-semibold',
                                            'bg-blue-100 text-blue-700' =>
                                                $movimiento->tipo === 'saldo_inicial',
                                            'bg-green-100 text-green-700' =>
                                                $movimiento->tipo === 'entrada',
                                            'bg-red-100 text-red-700' =>
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
                                        'text-green-700' =>
                                            $movimiento->tipo !== 'salida',
                                    ])>
                                        {{ $movimiento->tipo === 'salida' ? '−' : '+' }}
                                        ${{ number_format($movimiento->monto, 2) }}
                                    </td>
                                    <td class="flex items-center justify-end px-6 py-4">
                                        @if ($movimiento->comprobante)
                                            <a
                                                href="{{ Storage::url($movimiento->comprobante) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex px-1.5 py-1.5 bg-gray-100 border border-gray-300 rounded-md text-xs font-semibold text-gray-700 upperccase tracking-widest hover:bg-gray-200"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#000000"><path d="M720-330q0 104-73 177T470-80q-104 0-177-73t-73-177v-370q0-75 52.5-127.5T400-880q75 0 127.5 52.5T580-700v350q0 46-32 78t-78 32q-46 0-78-32t-32-78v-370h80v370q0 13 8.5 21.5T470-320q13 0 21.5-8.5T500-350v-350q-1-42-29.5-71T400-800q-42 0-71 29t-29 71v370q-1 71 49 120.5T470-160q70 0 119-49.5T640-330v-390h80v390Z"/></svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($movimientos->hasPages())
                    <div class="border-t border-gray-200 px-6 py-4">
                        {{ $movimientos->links() }}
                    </div>
                @endif
            </section>


            {{-- Notas --}}
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
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
                            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                        >
                            Agregar nota
                        </button>
                    @endcan
                </div>

                <div class="mt-6 space-y-4">
                    @forelse ($notas as $nota)
                        <article class="rounded-lg border border-gray-200 p-4">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $nota->usuario->name }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ $nota->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <p class="mt-3 whitespace-pre-line text-sm text-gray-700">
                                {{ $nota->comentario }}
                            </p>

                            @if ($nota->archivos->isNotEmpty())
                                <div class="mt-4">
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        Archivos
                                    </p>

                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($nota->archivos as $archivo)
                                            <a
                                                href="{{ \Illuminate\Support\Facades\Storage::url($archivo->archivo) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            >
                                                {{ $archivo->nombre_original }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </article>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-300 px-4 py-8 text-center">
                            <p class="text-sm text-gray-500">
                                Aún no hay notas registradas para este proyecto.
                            </p>
                        </div>
                    @endforelse
                </div>

                @if ($notas->hasPages())
                    <div class="mt-6">
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
                                class="fixed inset-0 bg-gray-900 bg-opacity-50"
                                onclick="closeNotaModal()"
                            ></div>

                            <div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl">
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
                                        class="text-2xl leading-none text-gray-400 hover:text-gray-600"
                                    >
                                        &times;
                                    </button>
                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('proyectos.notas.store', $proyecto) }}"
                                    enctype="multipart/form-data"
                                    class="space-y-4"
                                >
                                    @csrf

                                    <div>
                                        <label for="comentario" class="block text-sm font-medium text-gray-700">
                                            Nota
                                        </label>

                                        <textarea
                                            id="comentario"
                                            name="comentario"
                                            rows="5"
                                            required
                                            placeholder="Ej. Se terminó la limpieza del área norte del parque..."
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        >{{ old('comentario') }}</textarea>

                                        @error('comentario')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="nota_archivos" class="block text-sm font-medium text-gray-700">
                                            Archivos
                                        </label>

                                        <input
                                            type="file"
                                            id="nota_archivos"
                                            name="archivos[]"
                                            multiple
                                            accept=".pdf,.doc,.docx,.xls,.xlsx,image/*"
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
                                            onclick="closeNotaModal()"
                                            class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                                        >
                                            Cancelar
                                        </button>

                                        <button
                                            type="submit"
                                            class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
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
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">
                    Auditoría
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Historial de acciones realizadas dentro del proyecto.
                </p>

                <div class="mt-6 flow-root">
                    <ul class="-mb-8">
                        @foreach ($auditorias as $auditoria)
                            <li>
                                <div class="relative pb-8">
                                    @unless ($loop->last)
                                        <span class="absolute left-2.5 top-5 -ml-px
                                                     h-full w-px bg-gray-200"></span>
                                    @endunless

                                    <div class="relative flex gap-4">
                                        <span class="mt-1 flex h-5 w-5 items-center
                                                     justify-center rounded-full
                                                     bg-blue-600 ring-4 ring-white">
                                        </span>

                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm text-gray-700">
                                                <span class="font-semibold text-gray-900">
                                                    {{ $auditoria->usuario?->name ?? 'Sin asignar' }}
                                                </span>

                                                {{ $auditoria->descripcion }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $auditoria->created_at->format(
                                                    'd/m/Y H:i:s'
                                                ) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if ($auditorias->hasPages())
                    <div class="mt-5 border-t border-gray-200 pt-5">
                        {{ $auditorias->links() }}
                    </div>
                @endif
            </section>

        </div>
    </div>
</x-app-layout>
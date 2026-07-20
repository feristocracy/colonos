<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Proyectos
            </h2>

            @can('create', \App\Models\Proyecto::class)
                <a
                    href="{{ route('proyectos.create') }}"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2
                           text-sm font-semibold text-white shadow-sm
                           transition hover:bg-blue-700"
                >
                    Nuevo
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50
                            px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($proyectos->isEmpty())
                <div class="rounded-xl border border-gray-200 bg-white p-10
                            text-center shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800">
                        No hay proyectos registrados
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Los proyectos creados aparecerán en esta sección.
                    </p>
                </div>
            @else
                <div class="overflow-hidden rounded-xl border border-gray-200
                            bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold
                                               uppercase tracking-wider text-gray-600">
                                        Proyecto
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold
                                               uppercase tracking-wider text-gray-600">
                                        Líderes
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold
                                               uppercase tracking-wider text-gray-600">
                                        Monto inicial
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold
                                               uppercase tracking-wider text-gray-600">
                                        Saldo actual
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold
                                               uppercase tracking-wider text-gray-600">
                                        Acción
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($proyectos as $proyecto)
                                    @php
                                        $saldoActual =
                                            (float) ($proyecto->total_entradas ?? 0)
                                            - (float) ($proyecto->total_salidas ?? 0);
                                    @endphp

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900">
                                                {{ $proyecto->nombre }}
                                            </div>

                                            <div class="mt-1 text-xs text-gray-500">
                                                Creado por {{ $proyecto->creador->name }}
                                                el {{ $proyecto->created_at->format('d/m/Y') }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex max-w-sm flex-wrap gap-1">
                                                @foreach ($proyecto->lideres as $lider)
                                                    <span class="rounded-full bg-blue-50 px-2.5
                                                                 py-1 text-xs font-medium
                                                                 text-blue-700">
                                                        {{ $lider->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right
                                                   text-sm text-gray-700">
                                            ${{ number_format($proyecto->monto_inicial, 2) }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right
                                                   font-semibold text-gray-900">
                                            ${{ number_format($saldoActual, 2) }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <a
                                                href="{{ route('proyectos.show', $proyecto) }}"
                                                class="font-semibold text-blue-600
                                                       hover:text-blue-800"
                                            >
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $proyectos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
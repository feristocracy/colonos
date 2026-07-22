<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-800">
                Proyectos
            </h2>

            @can('create', \App\Models\Proyecto::class)
                <a
                    href="{{ route('proyectos.create') }}"
                    class="inline-flex items-center rounded-lg bg-violet-600 px-4 py-2.5
                           text-sm font-semibold text-white shadow-sm transition-all
                           duration-200 hover:bg-violet-700 hover:shadow-md focus:outline-none
                           focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                >
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuevo Proyecto
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-lg border border-violet-200 bg-violet-50
                            px-4 py-3 text-violet-800 shadow-sm">
                    <svg class="h-5 w-5 text-violet-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($proyectos->isEmpty())
                <div class="rounded-2xl border border-gray-100 bg-white p-12
                            text-center shadow-sm ring-1 ring-gray-900/5">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-violet-100">
                        <svg class="h-8 w-8 text-violet-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">
                        No hay proyectos registrados
                    </h3>
                    <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">
                        Los proyectos creados aparecerán en esta sección. Comienza creando tu primer proyecto para gestionarlo.
                    </p>
                    @can('create', \App\Models\Proyecto::class)
                        <div class="mt-6">
                            <a href="{{ route('proyectos.create') }}" class="inline-flex items-center text-sm font-medium text-violet-600 hover:text-violet-700">
                                <svg class="mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Crear nuevo proyecto
                            </a>
                        </div>
                    @endcan
                </div>
            @else
                <div class="overflow-hidden rounded-2xl border border-gray-100
                            bg-white shadow-sm ring-1 ring-gray-900/5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold
                                               uppercase tracking-wider text-gray-500">
                                        Proyecto
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold
                                               uppercase tracking-wider text-gray-500">
                                        Líderes
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold
                                               uppercase tracking-wider text-gray-500">
                                        Monto inicial
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold
                                               uppercase tracking-wider text-gray-500">
                                        Saldo actual
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold
                                               uppercase tracking-wider text-gray-500">
                                        Acción
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($proyectos as $proyecto)
                                    @php
                                        $saldoActual =
                                            (float) ($proyecto->total_entradas ?? 0)
                                            - (float) ($proyecto->total_salidas ?? 0);
                                    @endphp

                                    <tr class="group transition-colors duration-200 hover:bg-violet-50/50">
                                        <td class="px-6 py-5">
                                            <div class="font-semibold text-gray-900 transition-colors group-hover:text-violet-900">
                                                {{ $proyecto->nombre }}
                                            </div>

                                            <div class="mt-1 flex items-center text-xs text-gray-500">
                                                <svg class="mr-1.5 h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Creado por {{ $proyecto->creador->name }}
                                                el {{ $proyecto->created_at->format('d/m/Y') }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-5">
                                            <div class="flex max-w-sm flex-wrap gap-2">
                                                @foreach ($proyecto->lideres as $lider)
                                                    <span class="inline-flex items-center rounded-full bg-violet-100 px-2.5
                                                                 py-1 text-xs font-medium text-violet-800 ring-1 ring-inset ring-violet-600/10">
                                                        {{ $lider->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-right
                                                   text-sm font-medium text-gray-600">
                                            ${{ number_format($proyecto->monto_inicial, 2) }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-right
                                                   font-semibold text-gray-900">
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2.5 py-1 text-sm font-medium text-gray-700 ring-1 ring-inset ring-gray-500/10">
                                                ${{ number_format($saldoActual, 2) }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-right">
                                            <a
                                                href="{{ route('proyectos.show', $proyecto) }}"
                                                class="inline-flex items-center text-sm font-semibold text-violet-600
                                                       transition-colors hover:text-violet-800"
                                            >
                                                Ver detalles
                                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                </svg>
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

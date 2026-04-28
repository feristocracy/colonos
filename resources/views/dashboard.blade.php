<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-violet-900 leading-tight">
            {{ __('Tablero de Control') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Bienvenida -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-violet-900 tracking-tight mx-3">¡Hola, {{ Auth::user()->name }}!</h1>
                <p class="mt-2 text-sm text-violet-600/80 mx-3">Bienvenido al panel de administración de la asociación de colonos.</p>
            </div>

            <!-- Tarjetas de Métricas Rápidas (Próximamente) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Tarjeta: Colonos -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-violet-100/50 border border-violet-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-violet-50 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-violet-500 uppercase tracking-wider mb-1">Colonos Registrados</p>
                            <h3 class="text-3xl font-extrabold text-violet-900">{{ $totalColonos }}</h3>
                            <p class="text-xs font-medium text-violet-400 mt-2 flex items-center">
                                !Lleguemos a más!
                            </p>
                        </div>
                        <div class="p-3 bg-violet-100 rounded-xl text-violet-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta: Pagos del mes -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-emerald-100/50 border border-emerald-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Ingresos del Mes</p>
                            <h3 class="text-3xl font-extrabold text-emerald-600">$ {{ number_format($ingresosMes, 2) }}</h3>
                            <p class="text-xs font-medium text-emerald-400 mt-2 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                ¡Excelente trabajo!
                            </p>
                        </div>
                        <div class="p-3 bg-emerald-100 rounded-xl text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta: Egresos -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-rose-100/50 border border-rose-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-rose-600 uppercase tracking-wider mb-1">Egresos del Mes</p>
                            <h3 class="text-3xl font-extrabold text-rose-600">$ {{ number_format($egresosMes, 2) }}</h3>
                            <p class="text-xs font-medium text-rose-400 mt-2 flex items-center">
                                Inversiones para mejorar
                            </p>
                        </div>
                        <div class="p-3 bg-rose-100 rounded-xl text-rose-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta: Morosidad -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-amber-100/50 border border-amber-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Colonos Con Adeudo</p>
                            <h3 class="text-3xl font-extrabold text-amber-600">{{ $colonosConAdeudo }}</h3>
                            <p class="text-xs font-medium text-amber-400 mt-2 flex items-center">
                                ¡Vamos a contactarlos!
                            </p>
                        </div>
                        <div class="p-3 bg-amber-100 rounded-xl text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico y Actividad Reciente -->
            <div class="w-full">
                <!-- Gráfico de Ingresos/Egresos (Placeholder) -->
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            Ingresos y egresos {{ $year }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            Comparativo mensual de movimientos financieros
                        </p>
                    </div>
                </div>

                <div class="h-80">
                    <canvas id="finanzasChart"></canvas>
                </div>
            </div>
            </div>
            
        </div>
    </div>

    @push('scripts')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('finanzasChart');

            new window.Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                    'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
                ],
                datasets: [
                    {
                        label: 'Ingresos',
                        data: @json($ingresosPorMes),
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Egresos',
                        data: @json($egresosPorMes),
                        backgroundColor: 'rgba(239, 68, 68, 0.7)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString('es-MX');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': $' + context.raw.toLocaleString('es-MX');
                            }
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        });
    </script>
    @endpush
</x-app-layout>

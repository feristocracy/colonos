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
                            <h3 class="text-3xl font-extrabold text-violet-900">--</h3>
                            <p class="text-xs font-medium text-violet-400 mt-2 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Próximamente
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
                            <h3 class="text-3xl font-extrabold text-emerald-600">$ --</h3>
                            <p class="text-xs font-medium text-emerald-400 mt-2 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Próximamente
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
                            <h3 class="text-3xl font-extrabold text-rose-600">$ --</h3>
                            <p class="text-xs font-medium text-rose-400 mt-2 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Próximamente
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
                            <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Con Adeudo</p>
                            <h3 class="text-3xl font-extrabold text-amber-600">--</h3>
                            <p class="text-xs font-medium text-amber-400 mt-2 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Próximamente
                            </p>
                        </div>
                        <div class="p-3 bg-amber-100 rounded-xl text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico y Actividad Reciente -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Gráfico de Ingresos/Egresos (Placeholder) -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-xl shadow-violet-100/50 border border-violet-100 flex flex-col items-center justify-center min-h-[300px]">
                    <div class="w-16 h-16 bg-violet-50 rounded-full flex items-center justify-center text-violet-300 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-violet-900 mb-1">Gráfico de Movimientos</h3>
                    <p class="text-sm text-violet-500 font-medium">Esta sección mostrará un resumen visual próximamente.</p>
                </div>

                <!-- Accesos Rápidos -->
                <div class="bg-gradient-to-br from-violet-600 to-purple-700 rounded-3xl p-6 shadow-xl shadow-violet-200 text-white flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold mb-2 tracking-tight">Accesos Rápidos</h3>
                        <p class="text-violet-200 text-sm mb-6">Navega rápidamente a las secciones principales.</p>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('colonos.index') }}" class="flex items-center justify-between p-4 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-colors backdrop-blur-sm group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-white/20 rounded-lg group-hover:bg-white/30 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <span class="font-semibold text-sm">Nuevo Colono</span>
                            </div>
                            <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        
                        <a href="{{ route('pagos.index') }}" class="flex items-center justify-between p-4 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-colors backdrop-blur-sm group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-white/20 rounded-lg group-hover:bg-white/30 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="font-semibold text-sm">Registrar Pago</span>
                            </div>
                            <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>

                        <a href="{{ route('tesoreria.index') }}" class="flex items-center justify-between p-4 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 transition-colors backdrop-blur-sm group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-white/20 rounded-lg group-hover:bg-white/30 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="font-semibold text-sm">Ver Tesorería</span>
                            </div>
                            <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>

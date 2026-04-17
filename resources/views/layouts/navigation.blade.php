<nav x-data="{ open: false }" class="bg-white border-b border-violet-100 shadow-sm relative z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group">
                        <div class="mx-2">
                            <img class="w-12 h-auto" src="{{ asset('images/logo.png') }}" alt="Logo de la Asociación de Colónos">
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $navClasses = "inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out focus:outline-none ";
                        $activeClasses = $navClasses . "border-violet-600 text-violet-900";
                        $inactiveClasses = $navClasses . "border-transparent text-gray-500 hover:text-violet-600 hover:border-violet-300 focus:text-violet-700 focus:border-violet-300";
                    @endphp

                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $activeClasses : $inactiveClasses }}">
                        {{ __('Tablero') }}
                    </a>
                    <a href="{{ route('colonos.index') }}" class="{{ request()->routeIs('colonos.index') ? $activeClasses : $inactiveClasses }}">
                        {{ __('Colonos') }}
                    </a>
                    <a href="{{ route('pagos.index') }}" class="{{ request()->routeIs('pagos.index') ? $activeClasses : $inactiveClasses }}">
                        {{ __('Pagos') }}
                    </a>
                    <a href="{{ route('tesoreria.index') }}" class="{{ request()->routeIs('tesoreria.index') ? $activeClasses : $inactiveClasses }}">
                        {{ __('Tesorería') }}
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-violet-100 text-sm leading-4 font-semibold rounded-xl text-violet-700 bg-violet-50 hover:bg-violet-100 hover:text-violet-900 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            <div class="w-6 h-6 rounded-full bg-violet-200 flex items-center justify-center text-xs text-violet-800 border border-violet-300 mr-2">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-violet-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-violet-50 hover:text-violet-900 font-medium text-gray-700">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        @if(auth()->user()->role === 'admin')
                            <x-dropdown-link :href="route('register')" class="hover:bg-violet-50 hover:text-violet-900 font-medium text-gray-700">
                                {{ __('Registrar Usuario') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="hover:bg-rose-50 hover:text-rose-900 text-rose-600 font-medium border-t border-gray-100">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-violet-500 bg-violet-50 border border-violet-100 hover:text-violet-700 hover:bg-violet-100 focus:outline-none focus:bg-violet-100 focus:text-violet-700 focus:ring-2 focus:ring-violet-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-violet-50 border-t border-violet-100 absolute w-full shadow-lg z-50">
        <div class="pt-2 pb-3 space-y-1">
            @php
                $mobileNavClasses = "block w-full ps-3 pe-4 py-2.5 border-l-4 text-base font-bold transition duration-150 ease-in-out focus:outline-none ";
                $mobileActive = $mobileNavClasses . "border-violet-600 text-violet-900 bg-violet-100/50 focus:text-violet-900 focus:bg-violet-200 focus:border-violet-700";
                $mobileInactive = $mobileNavClasses . "border-transparent text-gray-600 hover:text-violet-800 hover:bg-violet-100/50 hover:border-violet-300 focus:text-violet-800 focus:bg-violet-50 focus:border-violet-300";
            @endphp

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $mobileActive : $mobileInactive }}">
                {{ __('Tablero') }}
            </a>
            <a href="{{ route('colonos.index') }}" class="{{ request()->routeIs('colonos.index') ? $mobileActive : $mobileInactive }}">
                {{ __('Colonos') }}
            </a>
            <a href="{{ route('pagos.index') }}" class="{{ request()->routeIs('pagos.index') ? $mobileActive : $mobileInactive }}">
                {{ __('Pagos') }}
            </a>
            <a href="{{ route('tesoreria.index') }}" class="{{ request()->routeIs('tesoreria.index') ? $mobileActive : $mobileInactive }}">
                {{ __('Tesorería') }}
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-violet-200 bg-white">
            <div class="px-4 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-violet-100 flex items-center justify-center text-violet-700 font-bold border border-violet-200 shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-base text-violet-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-violet-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-4 space-y-1">
                <a href="{{ route('profile.edit') }}" class="{{ $mobileInactive }}">
                    {{ __('Perfil') }}
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('register') }}" class="{{ $mobileInactive }}">
                        {{ __('Registrar Usuario') }}
                    </a>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block w-full ps-3 pe-4 py-2.5 border-l-4 border-transparent text-base font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-50 hover:border-rose-300 focus:outline-none focus:text-rose-800 focus:bg-rose-50 focus:border-rose-300 transition duration-150 ease-in-out">
                        {{ __('Cerrar Sesión') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-violet-900">
            {{ __('Eliminar cuenta de usuario') }}
        </h2>

        <p class="mt-1 text-sm text-violet-600/80">
            {{ __('Una vez que elimines tu cuenta, todas sus recursos y datos serán permanentemente eliminados. Antes de eliminar tu cuenta, por favor, descarga cualquier información que desees conservar.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-rose-600 hover:bg-rose-500 focus:ring-rose-500"
    >{{ __('Eliminar cuenta de usuario') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-violet-900">
                {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-violet-600/80">
                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-violet-200 focus:border-violet-500 focus:ring-violet-500/20 rounded-xl shadow-sm"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="border-violet-200 text-violet-700 hover:bg-violet-50 focus:ring-violet-500">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 bg-rose-600 hover:bg-rose-500 focus:ring-rose-500">
                    {{ __('Eliminar Cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

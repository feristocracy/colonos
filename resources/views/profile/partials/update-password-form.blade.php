<section>
    <header>
        <h2 class="text-lg font-medium text-violet-900">
            {{ __('Actualizar contraseña de usuario') }}
        </h2>

        <p class="mt-1 text-sm text-violet-600/80">
            {{ __('Asegúrate de que tu cuenta esté utilizando una contraseña larga y aleatoria para mantenerla segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña actual')" class="text-violet-900" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border-violet-200 focus:border-violet-500 focus:ring-violet-500/20 rounded-xl shadow-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Contraseña nueva de usuario')" class="text-violet-900" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border-violet-200 focus:border-violet-500 focus:ring-violet-500/20 rounded-xl shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar contraseña de usuario')" class="text-violet-900" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-violet-200 focus:border-violet-500 focus:ring-violet-500/20 rounded-xl shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-violet-600 hover:bg-violet-700 focus:bg-violet-700 active:bg-violet-900 focus:ring-violet-500 text-white">{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-medium"
                >{{ __('Guardado con éxito.') }}</p>
            @endif
        </div>
    </form>
</section>

<section>
    <header>
        <h2 class="text-lg font-medium text-violet-900">
            {{ __('Información del perfil') }}
        </h2>

        <p class="mt-1 text-sm text-violet-600/80">
            {{ __("Actualiza tu información del perfil y tu dirección electrónico de correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" class="text-violet-900" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-violet-200 focus:border-violet-500 focus:ring-violet-500/20 rounded-xl shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-violet-900" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-violet-200 focus:border-violet-500 focus:ring-violet-500/20 rounded-xl shadow-sm" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-violet-800">
                        {{ __('Tu dirección electrónico no ha sido verificada.') }}

                        <button form="send-verification" class="underline text-sm text-violet-600 hover:text-violet-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                            {{ __('Click aquí para reenviar el correo electrónico de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600">
                            {{ __('Se ha enviado un nuevo correo electrónico de verificación a tu dirección electrónico de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-violet-600 hover:bg-violet-700 focus:bg-violet-700 active:bg-violet-900 focus:ring-violet-500 text-white">{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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

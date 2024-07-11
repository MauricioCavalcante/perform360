<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex items-center justify-center mb-3 p-3">
        <img src="/img/logo_hitssbr.jpg" alt="GlobalHitss">
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email or Username -->
        <div>
            <x-input-label for="email_or_username" :value="__('Email ou Nome de usuário')" />
            <x-text-input id="email_or_username" class="block mt-1 w-full" type="text" name="email_or_username" :value="old('email_or_username')" required autofocus />
            <x-input-error :message="$errors->first('email_or_username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :message="$errors->first('password')" class="mt-2" />
        </div>

        <!-- Hidden Field for Identification -->
        <input type="hidden" name="login_field" value="email_or_username">

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="block mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            </div>
        @endif

        <!-- Login Button -->
        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-dark p-2 font-bold py-2 px-4">
                Entrar
            </button>
        </div>
    </form>
</x-guest-layout>

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf



        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="ramal" :value="__('Ramal')" />
            <x-text-input id="ramal" class="block mt-1 w-full" type="text" name="ramal" :value="old('ramal')" autocomplete="ramal" />
            <x-input-error :messages="$errors->get('ramal')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="grupos_id" :value="__('Select Group')" />
            <select id="grupos_id" name="grupos_id" class="block mt-1 w-full" required>
                <option value="">Selecione o grupo</option>
                <option value="1">Admin</option>
                <option value="2">Coordenador</option>
                <option value="3">Perfil de Qualidade</option>
                <option value="4">Atendente</option>
            </select>
            <x-input-error :messages="$errors->get('grupos_id')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="clientes_id" :value="__('Select Cliente')" />
            <select id="clientes_id" name="clientes_id" class="block mt-1 w-full" required>
                <option value="">Selecione o cliente</option>
                <option value="1">ANEEL</option>
                <option value="2">ANATEL</option>
            </select>
            <x-input-error :messages="$errors->get('clientes_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

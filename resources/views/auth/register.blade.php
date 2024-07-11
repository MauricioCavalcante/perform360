<x-guest-layout>

    <div>
        <img src="/img/global-hitss.png" style="height: 100px" alt="GlobalHitss">
    </div>

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
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="ramal" :value="__('Ramal')" />
            <x-text-input id="ramal" class="block mt-1 w-full" type="text" name="ramal" :value="old('ramal')" autocomplete="ramal" />
            <x-input-error :messages="$errors->get('ramal')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar senha')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="grupo_id" :value="__('Grupo')" />
            <select id="grupo_id" name="grupo_id" class="block mt-1 w-full" required autocomplete="grupo_id">
                <option value="">Selecione um grupo</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                        {{ $grupo->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('grupo_id')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="cliente" :value="__('Cliente')" />
            <div class="mt-2 space-y-2">
                @foreach ($clientes as $cliente)
                    <x-checkbox-input name="cliente_id[]" value="{{ $cliente->id }}" :checked="in_array($cliente->id, old('cliente_id', []))">
                        {{ $cliente->name }}
                    </x-checkbox-input>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('cliente_id')" class="mt-2" />
        </div>
        
        
        

        <div class="flex items-center justify-end mt-4">
            <a class="btn me-2 p-1" href="{{ route('user.painel_user') }}">Cancelar</a>
            <button type="submit" class="btn btn-dark me-2 p-1">Cadastrar</button>
        </div>
    </form>
</x-guest-layout>

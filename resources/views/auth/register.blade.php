@extends('layouts.main')

@section('title', 'Cadastro')

@section('head')
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>   
@endsection

@section('content')

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <div class="d-flex justify-content-center">
                <img src="/img/global-hitss.png" style="height: 150px" alt="GlobalHitss">
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
        
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
        
                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        
                <!-- Phone -->
                <div class="mt-4">
                    <x-input-label for="phone" :value="__('Telefone')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
        
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Senha')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
        
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar senha')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
        
                <!-- Group Selection -->
                <div class="mt-4">
                    <x-input-label for="group_id" :value="__('Tipo de perfil')" />
                    <select id="group_id" name="group_id" class="block mt-1 w-full" required autocomplete="group_id">
                        <option value="">Selecione um grupo</option>
                        @foreach ($groups as $group)
                            @if ($group->name !== 'ADMINISTRADOR')
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('group_id')" class="mt-2" />
                </div>
        
                <!-- Client Selection -->
                <div class="mt-4">
                    <x-input-label for="client_id" :value="__('Cliente')" />
                    <div class="mt-2 space-y-2">
                        @foreach ($clients as $client)
                            <x-checkbox-input name="client_id[]" value="{{ $client->id }}" :checked="in_array($client->id, old('client_id', []))">
                                {{ $client->name }}
                            </x-checkbox-input>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                </div>
        
                <!-- Buttons -->
                <div class="flex items-center justify-end mt-4 gap-3">
                    <a  href="{{ route('users.panel_users')}}">Cancelar</a>
                    <button type="submit" class="btn btn-dark me-2 p-1">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

@endsection
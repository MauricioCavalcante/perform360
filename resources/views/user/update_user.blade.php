@extends('layouts.main')

@section('title', 'Editar Usuário')

@section('head')
    <link rel="stylesheet" href="/css/styles.css">
@endsection

@section('content')



<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update user's information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('user.update', $user->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="cliente" :value="__('Cliente')" />
            <x-text-input id="cliente" name="cliente" type="text" class="mt-1 block w-full" :value="old('cliente', $user->cliente)" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('cliente')" />
        </div>

        <div>
            <x-input-label for="ramal" :value="__('Ramal')" />
            <x-text-input id="ramal" name="ramal" type="text" class="mt-1 block w-full" :value="old('ramal', $user->ramal)" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('ramal')" />
        </div>

        <div>
            <x-input-label for="score" :value="__('Score')" />
            <x-text-input id="score" name="score" type="text" class="mt-1 block w-full" :value="old('score', $user->score)" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('score')" />
        </div>

        <div>
            <x-input-label for="role" :value="__('Role')" />
            <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" :value="old('role', $user->role)" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

@endsection
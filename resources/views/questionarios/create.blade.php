@extends('layouts.main')

@section('title', isset($questionario) ? 'Editar Pergunta' : 'Nova Pergunta')
@section('head')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection
@section('content')

<main class="pagina-nova-pergunta">
    <div class="container-custom p-5 pt-3">
        <h3>Nova Pergunta</h3>
        <form class="form-group" action="{{ route('questionarios.store') }}" method="post">
            @csrf
        
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
            </div><br>
        
            <label for="pergunta">Pergunta:</label>
            <input type="text" id="pergunta" name="pergunta" class="form-control" value="{{ old('pergunta') }}" required><br>
        
            <label for="nota">Nota:</label>
            <input type="number" id="nota" name="nota" class="form-control" value="{{ old('nota') }}" min="1" max="10" step="any" required><br>
        
            <button class="btn btn-primary m-3" type="submit">Salvar</button>
        </form>
        
        
    </div>
</main>


@endsection
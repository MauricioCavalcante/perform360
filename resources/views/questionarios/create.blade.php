@extends('layouts.main')

@section('title', isset($questionario) ? 'Editar Pergunta' : 'Nova Pergunta')
@section('head')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection
@section('content')

<main class="pagina-nova-pergunta">
    <div class="container-custom p-5 pt-3">
        <h3>{{ isset($questionario) ? 'Editar Pergunta' : 'Nova Pergunta' }}</h3>
        <form class="form-group" action="{{ isset($questionario) ? route('questionarios.update', $questionario->id) : route('questionarios.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($questionario))
                @method('PUT')
            @endif

            <label for="clientes_id">Cliente:</label>
            <select id="clientes_id" name="clientes_id" class="form-control" required>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('clientes_id', isset($questionario) && $questionario->clientes_id == $cliente->id ? 'selected' : '') }}>{{ $cliente->nome }}</option>
                @endforeach
            </select><br>

            <label for="pergunta">Pergunta:</label>
            <input type="text" id="pergunta" name="pergunta" class="form-control" value="{{ old('pergunta', isset($questionario) ? $questionario->pergunta : '') }}" required><br>

            <label for="nota">Nota:</label>
            <input type="number" id="nota" name="nota" class="form-control" value="{{ old('nota', isset($questionario) ? $questionario->nota : '') }}" min="1" max="10" required><br>

            <button class="btn btn-primary m-3" type="submit">{{ isset($questionario) ? 'Atualizar' : 'Salvar' }}</button>
        </form>
    </div>
</main>


@endsection

@extends('layouts.main')

@section('title', 'Questionários')
@section('head')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection
@section('content')

<main class="pagina-questionarios">
    <div class="container-custom p-5 pt-3">
        <h3>Questionários</h3>
        <a href="{{ route('questionarios.create') }}" class="btn btn-primary m-3">Adicionar Pergunta</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pergunta</th>
                    <th>Nota</th>
                    <th>Cliente</th>
                    <th>Ações</th> <!-- Nova coluna para as ações -->
                </tr>
            </thead>
            <tbody>
                @foreach ($questionarios as $questionario)
                    <tr>
                        <td>{{ $questionario->id }}</td>
                        <td>{{ $questionario->pergunta }}</td>
                        <td>{{ $questionario->nota }}</td>
                        <td>{{ $questionario->cliente->nome }}</td>
                        <td>
                            <a href="{{ route('questionarios.edit', $questionario->id) }}" class="btn btn-sm btn-success text-decoration-none text-white">Editar</a>
                            <form action="{{ route('questionarios.delete', $questionario->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>


@endsection

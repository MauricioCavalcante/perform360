@extends('layouts.main')

@section('title', 'Nova Avaliação')
@section('head')
    <link rel="stylesheet" href="/css/novo_chamado.css">
@endsection
@section('content')

    <main class="pagina-novo-chamado">
        <div class="container-fluid p-5 pt-3">
            <h3>Nova Avaliação</h3>
            <form class="form-group" action="{{ route('avaliacoes.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="audio">Arquivo de Áudio:</label>
                <input type="file" id="audio" name="audio" accept="audio/*"><br><br>
                <button class="btn btn-primary m-3" type="submit">Salvar</button>
            </form>
        </div>
    </main>
    
@endsection

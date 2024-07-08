@extends('layouts.main')

@section('title', 'Nova Avaliação')
@section('head')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection
@section('content')


<main class="pagina-nova-avaliacao">
    <div class="container-custom p-5 pt-3">
        <h3>Nova Avaliação</h3>
        <form class="form-group" action="" method="post" enctype="multipart/form-data">
            @csrf
            <label for="audio">Arquivo de Áudio:</label>
            <input type="file" id="audio" name="audio" accept="audio/*"><br><br>
            <button class="btn btn-primary m-3" type="submit">Salvar</button>
        </form>
    </div>
</main>

@endsection

@extends('layouts.main')

@section('title', 'Nova Avaliação')
@section('head')
    <link rel="stylesheet" href="/css/evaluation.css">
@endsection
@section('content')

    <main class="container-custom container">
        <div class="container-fluid p-5">
            <h3>Nova Avaliação</h3>
            <form class="form-group mt-4" action="{{ route('evaluations.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-flex mb-3">
                    <label class="m-1 text-nowrap align-items-center" for="referent">Data referência:</label>
                    <input class="form-control date" type="date" name="referent">
                </div>
                <label for="audio">Arquivo de Áudio:</label>
                <input type="file" id="audio" name="audio" accept="audio/*">
                <div class="d-flex mt-5 justify-content-center">
                    <button class="btn btn-dark w-50" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </main>
 
@endsection

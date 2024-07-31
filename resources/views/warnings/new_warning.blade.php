@extends('layouts.main')

@section('title', 'Novo Aviso')
@section('head')
    <link rel="stylesheet" href="/css/evaluation.css">
@endsection
@section('content')

    <main class="container-custom container">
        <div class="container-fluid p-5">
            <h3>Novo Aviso</h3>
            <hr>
            <form class="mb-3" action="{{ route('warnings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="title">Título</label>
                    <input class="form-control" type="text" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="body">Mensagem</label>
                    <textarea class="form-control" name="body"></textarea>
                </div>
                <div  class="mb-3">
                    <label for="image">Imagem</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    <button class="btn btn-primary w-50" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </main>
@endsection

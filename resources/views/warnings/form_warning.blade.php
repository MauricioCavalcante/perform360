@extends('layouts.main')

@section('title', 'Novo Aviso')
@section('head')
    <link rel="stylesheet" href="/css/warning.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
            }
        }
    </script>
    <!-- Inclua o arquivo JavaScript -->
    <script type="module" src="/js/ckeditor.js"></script>
@endsection

@section('content')
    <main class="container-custom container">
        <div class="container-fluid p-5">
            <h3>{{ isset($warning) ? 'Editar Aviso' : 'Novo Aviso' }}</h3>
            <hr>
            <form class="form-group"
                action="{{ isset($warning) ? route('warnings.update', $warning->id) : route('warnings.store') }}"
                method="POST" enctype="multipart/form-data">
                @if (isset($warning))
                    @method('PUT')
                @endif
                @csrf

                <div class="mb-3 date d-flex gap-3">
                    <div>
                        <label for="start-{{ $warning->id ?? 'new' }}" class="form-label">Inicio</label>
                        <input type="datetime-local" class="form-control" id="start-{{ $warning->id ?? 'new' }}" name="start" value="{{ old('start', isset($warning) ? $warning->start : $now) }}">
                    </div>                    
                    
                    <div>
                        <label for="finish-{{ $warning->id ?? 'new' }}" class="form-label">Término</label>
                        <input type="datetime-local" class="form-control" id="finish-{{ $warning->id ?? 'new' }}" name="finish" value="{{ old('finish', isset($warning) ? $warning->finish : '') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="title-{{ $warning->id ?? 'new' }}" class="form-label">Título</label>
                    <input type="text" class="form-control" id="title-{{ $warning->id ?? 'new' }}" name="title" value="{{ old('title', isset($warning) ? $warning->title : '') }}">
                </div>
                <div class="mb-3">
                    <label for="body-{{ $warning->id ?? 'new' }}" class="form-label">Mensagem</label>
                    <textarea class="form-control ckeditor" id="body-{{ $warning->id ?? 'new' }}" name="body">{{ old('body', $warning->body ?? '') }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label for="image-{{ $warning->id ?? 'new' }}" class="form-label">Imagem</label>
                    <input type="file" class="form-control" id="image-{{ $warning->id ?? 'new' }}" name="image">
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    <button class="btn btn-primary w-50" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </main>

@endsection

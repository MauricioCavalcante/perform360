@extends('layouts.main')

@section('title', 'Avisos')

@section('head')
    <link rel="stylesheet" href="/css/warning.css">
@endsection

@section('content')
    <main class="container-custom container">
        @if (session('delete'))
            <div class="d-flex justify-content-center align-middle alert alert-info text-center">
                <p>{{ session('delete') }}</p>
            </div>
        @endif

        @if (session('success'))
            <div class="d-flex justify-content-center align-middle alert alert-primary text-center">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (Auth::user()->group_id === 2 || Auth::user()->group_id === 1)
            <aside class="d-flex justify-content-end">
                <a href="{{ route('warnings.create') }}" class="btn btn-dark">Novo aviso</a>
            </aside>
        @endif

        <section>
            @if ($warnings->isEmpty())
                <div class="d-flex m-5">
                    <p>Sem avisos.</p>
                </div>
            @else
                <div class="text-center">
                    <h3>Quadro de Avisos</h3>
                </div>
                <div class="d-flex row gap-3">
                    @foreach ($warnings as $warning)
                        <div class="card-container" id="card-container-{{ $warning->id }}" data-id="{{ $warning->id }}">
                            <div class="card col-3">
                                <!-- Lado da frente do card -->
                                <div class="card-front">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $warning->title }}</h5>
                                        <p class="card-text">{{ $warning->body }}</p>
                                        @if ($warning->image)
                                            <img src="{{ asset('storage/' . $warning->image) }}" class="card-img-top" alt="Imagem {{ $warning->title }}">
                                        @endif
                                        <div class="mt-3 d-flex justify-content-end gap-2">
                                            <form action="{{ route('warnings.destroy', $warning->id) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja deletar este aviso?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Deletar client">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                        <path
                                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <button class="btn btn-primary" onclick="flipCard({{ $warning->id }})">Editar</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Lado de trás do card com o formulário de edição -->
                                <div class="card-back" id="formContainer-{{ $warning->id }}">
                                    <form action="{{ route('warnings.update', $warning->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="title-{{ $warning->id }}" class="form-label">Título</label>
                                            <input type="text" class="form-control" id="title-{{ $warning->id }}" name="title" value="{{ old('title', $warning->title) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="body-{{ $warning->id }}" class="form-label">Mensagem</label>
                                            <input type="text" class="form-control" id="body-{{ $warning->id }}" name="body" value="{{ old('body', $warning->body) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image-{{ $warning->id }}" class="form-label">Imagem</label>
                                            <input type="file" class="form-control" id="image-{{ $warning->id }}" name="image" value="{{ old('body', $warning->body) }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <button type="button" class="btn btn-secondary" onclick="flipCard({{ $warning->id }})">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            @endif
        </section>
    </main>
    <script>
        function flipCard(id) {
            var cardContainer = document.getElementById('card-container-' + id);
            cardContainer.classList.toggle('flip');
        }
    </script>
    
    
@endsection

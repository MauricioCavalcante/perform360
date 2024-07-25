@extends('layouts.main')

@section('title', 'Clientes')

@section('head')
    <link rel="stylesheet" href="/css/client.css">
    <script src="/js/clients.js" defer></script>
@endsection

@section('content')

    <main class="container panel_client">
        <div>
            <h1 class="m-4">Clientes</h1>
        </div>
        <hr>

        @if (session('success'))
            <div class="d-flex justify-content-center align-middle alert alert-primary text-center">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <section class="container">
            <div class="d-flex justify-content-end container-fluid m-2">
                <a id="newClient" class="btn btn-dark">Novo cliente</a>
            </div>
            <!-- Formulário para criar um novo client -->
            <div id="formNewClient" class="form-container col-6 mb-3" style="display: none;">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código do projeto</label>
                        <input type="text" class="form-control" id="codigo" name="codigo"
                            value="{{ old('projeto') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                    <button type="button" class="btn btn-secondary" onclick="hideFormNewClient()">Cancelar</button>
                </form>
            </div>
            <div class="d-flex gap-3">
                @foreach ($client as $client)
                    <div class="card-container" data-id="{{ $client->id }}">
                        <div class="card col-3">
                            <!-- Lado da frente do card -->
                            <div class="card-front">
                                <h5 class="card-header">{{ $client->name }}</h5>
                                <div class="card-body">
                                    <p class="card-body">Projeto: {{ $client->codigo }}</p>
                                    <div class="d-flex justify-content-end mt-4 gap-2">
                                        <button class="btn btn-primary showFormEditClient" data-id="{{ $client->id }}"
                                            title="Editar cliente">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button>

                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja deletar este cliente?')">
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
                                    </div>
                                </div>
                            </div>
                            <!-- Lado de trás do card com o formulário de edição -->
                            <div class="card-back" id="formContainer-{{ $client->id }}">
                                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name-{{ $client->id }}" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="name-{{ $client->id }}"
                                            name="name" value="{{ old('name', $client->name) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="codigo-{{ $client->id }}" class="form-label">Codigo do
                                            Projeto</label>
                                        <input type="text" class="form-control" id="codigo-{{ $client->id }}"
                                            name="codigo" value="{{ old('codigo', $client->codigo) }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="hideFormclient({{ $client->id }})">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </section>
    </main>
@endsection

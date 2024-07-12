@extends('layouts.main')

@section('title', 'Usuários')

@section('head')
    <link rel="stylesheet" href="/css/usuarios.css">
@endsection

@section('content')
    @php
        use App\Models\Cliente;
    @endphp

    <main class="container pagina-usuarios">
        <h1 class="m-4">Clientes</h1>
        <hr>

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

        <section class="container pagina-usuarios">

            <div class="d-flex justify-content-end container-fluid m-2">
                <a id="novoCliente" class="btn btn-dark" onclick="toggleFormCliente()">Novo Cliente</a>
            </div>
            <div class="d-flex ms-3 mt-3 mb-2 gap-5">
                <div class="mt-1">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th colspan="2">Projeto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->name }}</td>
                                    <td>{{ $cliente->projeto }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button id="showFormEditarCliente-{{ $cliente->id }}"
                                                class="btn btn-success p-1" data-id="{{ $cliente->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                            </button>

                                            <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja deletar este cliente?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger p-1" title="Deletar Cliente">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                        <path
                                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="formNovoCliente" class="col-3" style="display: none">
                    <h4 class="mt-3">Novo Cliente</h4>
                    <form action="{{ route('cliente.store') }}" method="post">
                        @csrf
                        <div class="d-flex gap-2 align-middle">
                            <label class="form-label">Cliente</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="d-flex gap-2 align-middle mt-3">
                            <label class="form-label">Projeto</label>
                            <input type="text" class="form-control" name="projeto">
                        </div>
                        <button class="btn btn-success mt-3" type="submit">Salvar</button>
                    </form>
                </div>
                <div id="formEditarCliente" class="col-3" style="display: none;">
                    <h4 class="mt-3">Editar Cliente</h4>
                    <form method="post">
                        @method('PUT')
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Cliente')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required
                                autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="projeto" :value="__('Projeto')" />
                            <x-text-input id="projeto" name="projeto" type="text" class="mt-1 block w-full" required
                                autocomplete="projeto" />
                            <x-input-error class="mt-2" :messages="$errors->get('projeto')" />
                        </div>
                        <button class="btn btn-success mt-3" type="submit">Salvar</button>
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection

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

        <h3 class="m-4">Página do Gestor</h3>
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
        <div class="d-flex justify-content-center container-fluid m-2">
            <a id="painel_user" class="btn btn-ligth">Usuários</a>
            <a id="painel_cliente" class="btn btn-dark">Clientes</a>
        </div>
        <hr>
        <div class="d-flex justify-content-end container-fluid m-2">
            <a id="novoCliente" class="btn btn-dark" onclick="toggleFormCliente()">Novo Cliente</a>
        </div>
        <div id="clientes" class="d-flex ms-3 mt-3 mb-2 gap-5">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="formCliente" class="col-3">
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
        </div>
        <div class="d-flex justify-content-end container-fluid m-2">
            <a class="btn btn-dark" href="{{ route('register') }}">Novo Usuário</a>
        </div>
        <div id="usuarios" class="d-flex">
            <table class="table table-striped table-sm ">
                <thead class="">
                    <tr class='text-center text-nowrap table-dark'>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Cliente</th>
                        <th>Ramal</th>
                        <th>Pontuação</th>
                        <th colspan="2">Grupo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="text-center align-middle">
                            <td><a
                                    href="{{ route('user.painel_user_details', ['id' => $user->id]) }}">{{ $user->name }}</a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $clienteIds = explode(',', $user->cliente_id);
                                    $nomesClientes = [];

                                    foreach ($clienteIds as $clienteId) {
                                        $cliente = Cliente::find($clienteId);
                                        if ($cliente) {
                                            $nomesClientes[] = $cliente->name;
                                        }
                                    }
                                @endphp
                                {{ implode('/ ', $nomesClientes) }}
                            </td>
                            <td>{{ $user->ramal }}</td>
                            <td>{{ $user->score }}</td>
                            <td>{{ $user->Grupo->name }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </main>

@endsection

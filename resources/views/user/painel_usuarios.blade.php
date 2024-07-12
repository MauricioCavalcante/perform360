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

        <section class="container pagina-usuarios">

            <div id="showUsuarios">
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
            </div>
        </section>

    </main>
@endsection

@extends('layouts.main')

@section('title', 'Usuário')

@section('head')
    <link rel="stylesheet" href="/css/usuarios.css">
@endsection

@section('content')

    <main class="container">
        <div class="d-flex">
            <h3 class="m-4" id="nome">{{ $user->name }} </h3>
            <span class="z-n1 alert alert-success d-flex align-items-center ms-auto me-5">{{ $user->score }} Pontos</span>
        </div>

        <div class="row mb-3">
            <div class="col-auto text-end">
                <div><strong>Nome de usuário:</strong></div>
                <div><strong>E-mail:</strong></div>
                <div><strong>Cliente:</strong></div>
                <div><strong>Perfil:</strong></div>
                <div><strong>Ramal:</strong></div>
                <div><strong>Cliente:</strong></div>
            </div>
            <div class="col">
                <div>{{ $user->username }}</div>
                <div>{{ $user->email }}</div>
                <div>{{ $user->cliente }}</div>
                <div>{{ $user->role }}</div>
                <div>{{ $user->ramal }}</div>
                <div>{{ $user->cliente }}</div>
            </div>
        </div>

        @auth
            @if (auth()->user()->role === 'COORDENADOR')
                <div>
                    <a href="javascript:void(0);" class="btn btn-success">Editar</a>
                </div>
            @endif
        @endauth


    <div class="table-responsive mt-5">
        <h4>Histórico de chamados</h4>
        <table class="table table-striped table-sm">
            <thead>
                <tr class='align-middle text-nowrap text-center'>
                    <th>Atendente</th>
                    <th>Cliente</th>
                    <th>Número do Chamado</th>
                    <th>Título</th>
                    <th>Registro</th>
                    <th>Avaliação</th>
                </tr>
            </thead>
            <tbody>
                <!-- Itere sobre os chamados do usuário, se houver -->
            </tbody>
        </table>
    </div>
</main>

@endsection

@extends('layouts.main')

@section('title', 'Meu Perfil')

@section('head')
    <link rel="stylesheet" href="/css/usuarios.css">
@endsection

@section('content')


    <main class="container">
        <div class="d-flex">
            <h3 class="m-4" id="nome">{{ Auth::user()->name }} </h3>
            <span class="z-n1 alert alert-success d-flex align-items-center ms-auto me-5">{{ Auth::user()->score }}
                Pontos</span>
        </div>


        <div class="table-responsive col-6">
            <table class="table table-striped table-sm align-middle text-nowrap">
                <tr>
                    <th>Nome de usuário</th>
                    <td>{{ Auth::user()->username }}</td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td>{{ Auth::user()->email }}</td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td>{{ Auth::user()->cliente->name }}</td>
                </tr>
                <tr>
                    <th>Perfil</th>
                    <td>{{ Auth::user()->grupo_id }}</td>
                </tr>
                <tr>
                    <th>Ramal</th>
                    <td>{{ Auth::user()->ramal }}</td>
                </tr>
            </table>
        </div>
        <div>
            <a href="javascript:void(0);" class="btn btn-dark">Alterar senha</a>

        </div>
        <div class="mt-5">
            <h4>Histórico de chamados</h4>
            <div class="table-responsive mt-5">
                <table class="table table-striped table-sm text-center text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Atendente</th>
                            <th>Cliente</th>
                            <th>Protocolo de Atendimento</th>
                            <th>Iniciado por</th>
                            <th>Registro</th>
                            <th>Avaliação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($avaliacaos as $avaliacao)
                            @if ($avaliacao->id_user == Auth::user()->id)
                                <tr>
                                    <td><a href="/avaliacoes/details_avaliacao/{{ $avaliacao->id }}">{{ $avaliacao->id }}</a>
                                    </td>
                                    <td>{{ $avaliacao->id_user ? $avaliacao->user->name : 'Não definido' }}</td>
                                    <td>{{ $avaliacao->cliente ? $avaliacao->cliente->name : 'Não definido' }}</td>
                                    <td>{{ $avaliacao->num_chamado }}</td>
                                    <td>{{ $avaliacao->usuario }}</td>
                                    <td>{{ $avaliacao->created_at }}</td>
                                    <td>{{ $avaliacao->avaliacao }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            
        </div>
    </main>

@endsection

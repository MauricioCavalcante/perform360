@extends('layouts.main')

@section('title', 'Meu Perfil')

@section('head')
    <link rel="stylesheet" href="/css/usuarios.css">
@endsection

@section('content')


<main class="container">
    <div class="d-flex">
        <h3 class="m-4" id="nome">{{ Auth::user()->name }} </h3>
        <span class="z-n1 alert alert-success d-flex align-items-center ms-auto me-5">{{ Auth::user()->score }} Pontos</span>
    </div>


    <div class="table-responsive">
        <table class="table table-striped table-sm align-middle text-nowrap">
            <tr>
                <th>ID_Usuário</th>
                <td>{{ Auth::user()->id }}</td>
            </tr>
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
                <td>{{ Auth::user()->cliente }}</td>
            </tr>
            <tr>
                <th>Perfil</th>
                <td>{{ Auth::user()->role }}</td>
            </tr>
            <tr>
                <th>Ramal</th>
                <td>{{ Auth::user()->ramal }}</td>
            </tr>
        </table>
    </div>
    <div>
        <a href="javascript:void(0);" class="btn btn-success">Editar</a>

    </div>
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


            </tbody>
        </table>
    </div>
</main>

@endsection
@extends('layouts.main')

@section('title', 'Avaliação')


@section('head')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('content')

<main class="container-custom">
    <h3>Detalhes do Chamado</h3>
    <div class="row">
        <div class="col table-responsive">
            <table class="table table-striped table-sm align-middle text-nowrap">
                <tr>
                    <th>ID_Chamado</th>
                    <td>{{ $id }}</td>
                </tr>
                <tr>
                    <th>Atendente</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Número do Chamado</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Título</th>
                    <td></td>
                </tr>

                <tr>
                    <th>Data de Registro</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Avaliação</th>
                    <td></td>
                </tr>
                <tr>
                    <th>FeedBack</th>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="col">
            <div class="row d-flex align-items-center">
                <h6 class="col-auto">Áudio:</h6>
                    <audio controls class="col">
                        <source src="" type="audio/">
                        Seu navegador não suporta o elemento de áudio.
                    </audio>
            </div>
            <div class="form-floating mt-3">
                <textarea class="form-control" name="transcricao" id="transcricao" style="display: none;"></textarea>
            </div>
        </div>
    </div>
    <div>
        <button class="btn btn-success">Editar</button>
    </div>
</main>

@endsection

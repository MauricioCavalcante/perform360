@extends('layouts.main')

@section('title', 'Avaliações')

@section('head')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('content')

    <main class="container-custom">
        <h3 class="m-4">Avaliações registradas</h3>

        <div class="table table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr class='align-middle text-nowrap text-center'>
                        <th>ID_Avaliação</th>
                        <th>Áudio</th>
                        <th>Registro</th>
                        <th>Avaliação</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><a href="{{ asset('/avaliacoes/details_avaliacao')}}">Link</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>


@endsection

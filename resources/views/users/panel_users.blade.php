@extends('layouts.main')

@section('title', 'Usuários')

@section('head')
    <link rel="stylesheet" href="/css/user.css">
@endsection

@section('content')
    <main class="container panel_user">
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
                <div id="usuarios" class="d-flex table-responsive">
                    <table class="table table-striped table-bordered table-sm ">
                        <thead class="">
                            <tr class='text-center text-nowrap table-dark'>
                                <th>Classificação</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Cliente</th>
                                <th>Ramal</th>
                                <th>Pontuação</th>
                                <th>Grupo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="text-center text-nowrap align-middle ">
                                    <td>
                                        {{-- {{ $rank++ }}º --}}
                                    </td>
                                    <td><a
                                            href="{{ route('users.panel_users_details', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @php
                                            $clientIds = json_decode($user->client_id);
                                            $clientNames = [];
                                            if ($clientIds) {
                                                foreach ($clientIds as $clientId) {
                                                    $client = $clients->where('id', $clientId)->first();
                                                    if ($client) {
                                                        $clientNames[] = $client->name;
                                                    }
                                                }
                                            }
                                            echo implode(' / ', $clientNames);
                                        @endphp
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        {{ $user->score }}
                                    </td>
                                    <td>{{ $user->Group->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>
@endsection

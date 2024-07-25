@extends('layouts.main')

@section('title', 'Meu Perfil')

@section('head')
    <link rel="stylesheet" href="/css/user.css">
@endsection

@section('content')
    @php
        use App\Models\Client;
    @endphp
    @if (session('status'))
        <div class="d-flex justify-content-center align-middle alert alert-danger text-center">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <main class="container details_user">
        <div class="d-flex">
            <h3 class="m-4" id="nome">{{ Auth::user()->name }} </h3>
            {{-- <span class="z-n1 alert alert-success d-flex align-items-center ms-auto me-5">{{ $avgScore }}
                Pontos</span> --}}
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
                    <td>
                        @php
                            $clientIds = json_decode(Auth::user()->client_id);
                            $namesclients = [];

                            foreach ($clientIds as $clientId) {
                                $client = Client::find($clientId);
                                if ($client) {
                                    $namesclients[] = $client->name;
                                }
                            }
                        @endphp
                        {{ implode('/ ', $namesclients) }}
                    </td>
                </tr>
                <tr>
                    <th>Perfil</th>
                    <td>{{ Auth::user()->group_id ? Auth::user()->group->name : 'Nenhum grupo associado.' }}</td>
                </tr>
                <tr>
                    <th>Ramal</th>
                    <td>{{ Auth::user()->phone }}</td>
                </tr>
            </table>
        </div>
        <div>
            <a href="{{ route('profile.update-password') }}" class="btn btn-dark">Alterar senha</a>
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
                            <th>Avaliação</th>
                            <th>Comentário</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluation as $evaluation)
                            @if ($evaluation->id_user == Auth::user()->id)
                                <tr>
                                    <td><a
                                            href="/evaluations/details_evaluation/{{ $evaluation->id }}">{{ $evaluation->id }}</a>
                                    </td>
                                    <td>{{ $evaluation->user_id ? $evaluation->user->name : 'Não definido' }}</td>
                                    <td>{{ $evaluation->client ? $evaluation->client->name : 'Não definido' }}</td>
                                    <td>{{ $evaluation->protocol }}</td>
                                    <td>{{ $evaluation->score }}</td>
                                    <td>{{ $evaluation->feedback }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

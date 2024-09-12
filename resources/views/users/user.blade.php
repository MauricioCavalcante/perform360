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

    <main class="container-custom container">
        <section class="container-user m-4 mt-1 pt-4 row p-4">
            <div class="d-flex justify-content-between ms-5">
                <h3 class="mt-4 text-center" id="nome">{{ Auth::user()->name }} </h3>
                <div class="d-none d-lg-block">
                    @if (Auth::user()->group_id == 4)
                        @if ($avgScore)
                            <div class="ms-auto fillScore">
                                <div id="boxUp"></div>
                                <div id="score" class="borda" style="--fill: {{ $avgScore / 100 }};"></div>
                                <div id="boxDown"></div>
                                <div class="score"><strong>{{ $avgScore }} Pontos</strong></div>
                                <div id="indicator" style="--fill: {{ $avgScore / 100 }};"></div>
                            </div>
                        @else
                            <div class="ms-auto fillScore">
                                <div id="boxUp"></div>
                                <div id="score" class="borda" style="--fill: {{ $avgScore ? $avgScore / 100 : 1 }};"></div>
                                <div id="boxDown"></div>
                                <div class="score"><strong>{{ $avgScore ?: 100 }} Pontos</strong></div>
                                <div id="indicator" style="--fill: {{ $avgScore ? $avgScore / 100 : 1 }};"></div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-auto pb-1">
                <div class="table-responsive d-flex justify-content-between p-4 mt-2">
                    <table class="table table-striped table-md align-middle text-nowrap">
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
                        @if ($user->phone)
                            <tr>
                                <th>Ramal</th>
                                <td>{{ Auth::user()->phone }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div>
                    <button onclick="updatePassword()" class="btn btn-dark ms-5">Alterar senha</button>
                </div>
                <div id="updatePasswordForm" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-2 rounded"
                    style="display: none;">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </section>
        <div class="mt-5 container-custom">
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
                                    <td><a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                            href="/evaluations/details_evaluation/{{ $evaluation->id }}">{{ $evaluation->id }}</a>
                                    </td>
                                    <td>{{ $evaluation->user_id ? $evaluation->user->name : 'Não definido' }}</td>
                                    <td>{{ $evaluation->client ? $evaluation->client->name : 'Não definido' }}</td>
                                    <td>{{ $evaluation->protocol }}</td>
                                    <td>{{ $evaluation->score }}</td>
                                    <td><div class="truncate-cell">{!! $evaluation->feedback !!}</div></td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

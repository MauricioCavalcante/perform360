@extends('layouts.main')

@section('title', 'Usuário')

@section('head')
    <link rel="stylesheet" href="/css/user.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
    @php
        use App\Models\Client;

        $clientIds = json_decode($user->client_id);
        $namesClients = [];

        foreach ($clientIds as $clientId) {
            $client = Client::find($clientId);
            if ($client) {
                $namesClients[$user->id][] = $client->name;
            }
        }
    @endphp

    <main class="container-custom container">
        @if (session('status'))
            <div class="d-flex justify-content-center align-middle alert alert-primary text-center">
                <p>{{ session('status') }}</p>
            </div>
        @endif
        <section class="container-user m-5 mt-1 p-5">
            <div class="container d-flex align-items-center">
                <div class="d-flex">
                    <div id="nameUser" class="align-items-center">
                        <div class="d-flex">
                            <h3 id="nome">{{ $user->name }}</h3>
                            <button class="btn p-1 m-1" id="toggleNameConfigBtn" onclick="toggleNameConfigEdit()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="nameConfigContainer" class="align-items-center" style="display: none;">
                        <form action="{{ route('users.updateName', ['id' => $user->id]) }}" method="post"
                            class="d-flex gap-2">
                            @csrf
                            @method('PUT')
                            <h3>
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </h3>
                            <div class="d-flex align-items-center gap-1">
                                <button class="btn btn-primary p-1" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 17">
                                        <path
                                            d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                    </svg>
                                </button>
                                <button class="btn btn-danger p-1" type="button" onclick="toggleNameConfigCancel()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 17">
                                        <path
                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1-.708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div>

                </div>
                @if ($user->group_id == 4)
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

            <div id="infoUser" class="row mb-3">
                <div class="col-auto">
                    <div class="mt-2"><strong>E-mail:</strong></div>
                    <div class="mt-2"><strong>Cliente:</strong></div>
                    <div class="mt-2"><strong>Perfil:</strong></div>
                    <div class="mt-2">
                        @if ($user->phone)
                            <strong>Ramal:</strong>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <div class="mt-2">{{ $user->email }}</div>
                    <div class="mt-2">
                        @if (array_key_exists($user->id, $namesClients))
                            {{ implode('/ ', $namesClients[$user->id]) }}
                        @else
                            <p>Sem clientes associado.</p>
                        @endif
                    </div>
                    <div class="mt-2">{{ $user->group->name }}</div>
                    <div class="mt-2">{{ $user->phone }}</div>
                    <div class="d-flex gap-1 mt-3">
                        <button id="editButton" class="btn btn-primary">Editar</button>
                        <form action="{{ route('users.delete', $user->id) }}" method="post"
                            onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="confiUser" class="row" style="display: none;">
                <div class="col-auto">
                    <div class="mt-2"><strong>E-mail:</strong></div>
                    <div class="mt-3"><strong>Cliente:</strong></div>
                    <div class="mt-4"><strong>Perfil:</strong></div>
                    <div class="mt-4"><strong>Ramal:</strong></div>
                </div>
                <div class="col-auto">
                    <div class="">
                        <form action="{{ route('users.updateUser', ['id' => $user->id]) }}" method="post">
                            @csrf
                            @method('PUT')

                            <input class="form-control" type="email" id="email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                            <div class="d-flex">
                                <div class="mt-2 gap-1 btn-group">
                                    @foreach ($clients as $client)
                                        <x-checkbox-input name="client_id[]" value="{{ $client->id }}"
                                            :checked="in_array($client->id, old('client_id', []))">
                                            {{ $client->name }}
                                        </x-checkbox-input>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                            </div>


                            <div class="mt-2">
                                <select class="form-select" id="group_id" name="group_id" required
                                    autocomplete="group_id">
                                    <option value="">Selecione um group</option>
                                    @foreach ($group as $group)
                                        @if ($group->name !== 'ADMINISTRADOR')
                                            <option value="{{ $group->id }}"
                                                {{ old('group_id', $user->group_id) == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" id="phone" name="phone" class="form-control mt-2"
                                value="{{ old('phone', $user->phone) }}"><br>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <a id="cancelButton" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="container-custom table-responsive mb-1">
            <h4>Histórico de chamados</h4>
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
                        @if ($evaluation->user_id == $user->id)
                            <tr>
                                <td><a
                                        href="/evaluations/details_evaluation/{{ $evaluation->id }}">{{ $evaluation->id }}</a>
                                </td>
                                <td>{{ $evaluation->user_id ? $evaluation->user->name : 'Não definido' }}</td>
                                <td>{{ $evaluation->client_id ? $evaluation->client->name : 'Não definido' }}</td>
                                <td>{{ $evaluation->protocol }}</td>
                                <td>{{ $evaluation->score }}</td>
                                <td><div class="truncate-cell">{!! $evaluation->feedback !!}</div></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    <script>
        function toggleNameConfigEdit() {
            $('#nameUser').toggle();
            $('#nameConfigContainer').toggle();
        }

        function toggleNameConfigCancel() {
            $('#nameConfigContainer').hide();
            $('#nameUser').show();
        }

        $(document).ready(function() {
            $('#editButton').on('click', function() {
                $('#infoUser').hide();
                $('#confiUser').show();
            });

            $('#cancelButton').on('click', function() {
                $('#infoUser').show();
                $('#confiUser').hide();
            });
        });
    </script>
@endsection

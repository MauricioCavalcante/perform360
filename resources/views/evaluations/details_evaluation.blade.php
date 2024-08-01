@extends('layouts.main')

@section('title', 'Avaliação')

@section('head')
    <link rel="stylesheet" href="/css/evaluation.css">
@endsection

@section('content')
    <main class="container-custom">
        <h3 class="m-4">Avaliação - {{ $evaluation->id }}</h3>
        @if (session('success'))
            <div class="d-flex justify-content-center align-middle alert alert-success text-center">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="d-flex justify-content-center align-middle alert alert-danger text-center">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        <div class="row details_evaluation mb-4">
            <div class="col-6">
                <div class="row d-flex align-items-center">
                    <h6 class="col-auto">Áudio:</h6>
                    @if ($evaluation->audio)
                        @php
                            $audioUrl = Storage::url($evaluation->audio);
                        @endphp
                        <audio controls>
                            <source src="{{ $audioUrl }}" type="audio/wav">
                            Seu navegador não suporta áudio HTML5.
                            <p>Caminho do áudio: {{ $audioUrl }}</p> <!-- Adicionado para debug -->
                        </audio>
                    @else
                        <p>Nenhum áudio disponível.</p>
                    @endif
                </div>
                <div>
                    <h5>Transcrição</h5>
                    @if ($evaluation->transcription)
                        <p>{{ $evaluation->transcription }}</p>
                    @else
                        <div class="d-flex m-5">
                            <div class="m-1" id="loader"></div>
                            <p class="ms-2">Transcrição em andamento, aguarde!</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="d-flex align-items-center justify-content-end mb-2 gap-2">
                    @auth
                        @if (Auth::user()->group_id == 2 || Auth::user()->group_id == 1)
                            @if ($evaluation->client_id)
                                <div>
                                    <a href="{{ route('evaluations.questionnaire', $evaluation->id) }}"
                                        class="btn btn-success">Avaliar</a>
                                </div>
                            @endif
                            <div>
                                <button id="edit" class="btn btn-primary">Categorizar</button>
                            </div>
                            <div>

                                <form method="POST" action="{{ route('evaluations.destroy', $evaluation->id) }}"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
                <div id="evaluation">
                    <table class="table table-striped align-middle text-nowrap">
                        <tr>
                            <th>ID da Avaliação</th>
                            <td>{{ $evaluation->id }}</td>
                        </tr>
                        <tr>
                            <th>Atendente</th>
                            <td>
                                @if ($evaluation->user_id)
                                    {{ $evaluation->user->name }}
                                @else
                                    Não definido
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Cliente</th>
                            <td>
                                @if ($evaluation->client_id)
                                    {{ $evaluation->client->name }}
                                @else
                                    Não definido
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Protocolo de Atendimento</th>
                            <td>{{ $evaluation->protocol }}</td>
                        </tr>
                        <tr>
                            <th>Iniciado por</th>
                            <td>{{ $evaluation->username }}</td>
                        </tr>
                        <tr>
                            <th>Data de Registro do Chamado</th>
                            <td>{{ $evaluation->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Avaliação do Chamado</th>
                            <td>{{ $evaluation->score }}</td>
                        </tr>
                        <tr>
                            <th>Feedback do Chamado</th>
                            <td>{{ $evaluation->feedback }}</td>
                        </tr>
                    </table>
                </div>
                <div id="formEdit" style="display: none;">
                    <form class="form-edit form-group" method="POST"
                        action="{{ route('evaluations.update', $evaluation->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="form-label" for="user_id"><strong>Atendente</strong></label>
                            <select id="user_id" name="user_id" class="mt-1 block w-full form-control">
                                @foreach ($user as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == old('user_id', $evaluation->user_id) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_user')" />
                        </div>

                        <div>
                            <label class="form-label mt-2" for="protocol"><strong>Protocolo de
                                    Atendimento</strong></label>
                            <x-text-input id="protocol" name="protocol" type="text" class="form-control"
                                :value="old('protocol', $evaluation->protocol)" autofocus autocomplete="protocol" />
                            <x-input-error :messages="$errors->get('protocol')" />
                        </div>

                        <div>
                            <label class="form-label mt-2" for="client_id"><strong>Cliente</strong></label>
                            <select id="client_id" name="client_id" class="mt-1 block w-full form-control">
                                <option value="">Selecione um cliente</option>
                                @foreach ($client as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $client->id == old('client_id', $evaluation->client_id) ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('client_id')" />
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success ps-5 pe-5">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">

        </div>
    </main>


@endsection

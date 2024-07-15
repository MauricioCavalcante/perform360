@extends('layouts.main')

@section('title', 'Avaliação')

@section('content')
    <main class="container">
        <h3 class="m-4">Avaliação - {{ $avaliacao->id }}</h3>
        @if (session('success'))
            <div class="d-flex justify-content-center align-middle alert alert-success text-center">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <hr>
        <div class="row">
            <div class="col-6">
                <div class="row d-flex align-items-center">
                    <h6 class="col-auto">Áudio:</h6>
                    @if(!empty($avaliacao->audio))
                        @php
                            $audioUrl = Storage::url($avaliacao->audio);
                        @endphp

                        <audio controls>
                            <source src="{{ $audioUrl }}" type="audio/wav">
                            Seu navegador não suporta áudio HTML5.
                            <p>Caminho do áudio: {{ $audioUrl }}</p>
                        </audio>
                    @else
                        <p>Nenhum áudio disponível.</p>
                    @endif

                </div>
                <div>
                    <h5>Transcrição</h5>
                    @if ($avaliacao->transcricao)
                        <p>{{ $avaliacao->transcricao }}</p>
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
                    <div>
                        <!-- Botão de editar -->
                        <button id="editar" class="btn btn-primary">Categorizar</button>
                    </div>
                    <div>
                        @auth
                            @if (auth()->user()->grupo_id == 2)
                                <form method="POST" action="{{ route('avaliacoes.destroy', $avaliacao->id) }}"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            @endif

                        @endauth
                    </div>
                </div>
                <div id="avaliacao">
                    <table class="table table-striped align-middle text-nowrap">
                        <tr>
                            <th>ID da Avaliação</th>
                            <td>{{ $avaliacao->id }}</td>
                        </tr>
                        <tr>
                            <th>Atendente</th>
                            <td>
                                @if ($avaliacao->user)
                                    {{ $avaliacao->user->name }}
                                @else
                                    Não definido
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Cliente</th>
                            <td>
                                @if ($avaliacao->cliente)
                                    {{ $avaliacao->cliente->name }}
                                @else
                                    Não definido
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Protocolo de Atendimento</th>
                            <td>{{ $avaliacao->num_chamado }}</td>
                        </tr>
                        <tr>
                            <th>Iniciado por</th>
                            <td>{{ $avaliacao->usuario }}</td>
                        </tr>
                        <tr>
                            <th>Data de Registro do Chamado</th>
                            <td>{{ $avaliacao->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Avaliação do Chamado</th>
                            <td>{{ $avaliacao->avaliacao }}</td>
                        </tr>
                        <tr>
                            <th>Feedback do Chamado</th>
                            <td>{{ $avaliacao->feedback }}</td>
                        </tr>
                    </table>
                </div>
                <div id="formEditar">
                    <form class="form-editar form-group" method="POST"
                        action="{{ route('avaliacoes.update', $avaliacao->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="form-label" for="id_user"><strong>Atendente</strong></label>
                            <select id="id_user" name="id_user" class="mt-1 block w-full form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == old('id_user', $avaliacao->id_user) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_user')" />
                        </div>

                        <div>
                            <label class="form-label mt-2" for="num_chamado"><strong>Protocolo de
                                    Atendimento</strong></label>
                            <x-text-input id="num_chamado" name="num_chamado" type="text" class="form-control"
                                :value="old('num_chamado', $avaliacao->num_chamado)" required autofocus autocomplete="num_chamado" />
                            <x-input-error :messages="$errors->get('num_chamado')" />
                        </div>

                        <div>
                            <label class="form-label mt-2" for="cliente_id"><strong>Cliente</strong></label>
                            <select id="cliente_id" name="cliente_id" class="mt-1 block w-full form-control">
                                <option value="">Selecione um cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ $cliente->id == old('cliente_id', $avaliacao->id_cliente) ? 'selected' : '' }}>
                                        {{ $cliente->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('cliente_id')" />
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

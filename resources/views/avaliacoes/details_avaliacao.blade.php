@extends('layouts.main')

@section('title', 'Avaliação')

@section('head')
    <link rel="stylesheet" href="/css/novo_chamado.css">
    <style>
        /* Estilos adicionais podem ser definidos aqui */
        .form-editar {
            display: none;
            /* Inicialmente oculto */
            margin-top: 20px;
        }
    </style>
@endsection

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
                    @if ($avaliacao->audio)
                        <audio controls>
                            <source src="{{ Storage::url($avaliacao->audio) }}" type="audio/wav">
                            Seu navegador não suporta áudio HTML5.
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
            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <!-- Botão de editar -->
                    <button id="editar" class="btn btn-primary mt-3" onclick="exibirFormEditar()">Categorizar</button>
                </div>
                <div>

                    <table id="avaliacao" class="table table-striped align-middle text-nowrap">
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
                            <th>Número do Chamado</th>
                            <td>{{ $avaliacao->num_chamado }}</td>
                        </tr>
                        <tr>
                            <th>Título do Chamado</th>
                            <td>{{ $avaliacao->titulo }}</td>
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


                <!-- Formulário de edição -->
                <form class="form-editar form-group" id="formEditar" method="POST"
                    action="{{ route('avaliacoes.update', $avaliacao->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Campo para selecionar o atendente -->
                    <div>
                        <x-input-label class="form-label" for="id_user" :value="__('Atendente')" />
                        <select id="id_user" name="id_user" class="mt-1 block w-full form-control" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $user->id == old('id_user', $avaliacao->id_user) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('id_user')" />
                    </div>

                    <!-- Campo para número do chamado -->
                    <div>
                        <x-input-label class="form-label" for="num_chamado" :value="__('Número do chamado: ')" />
                        <x-text-input id="num_chamado" name="num_chamado" type="text"
                            class="mt-1 block w-full form-control" :value="old('num_chamado', $avaliacao->num_chamado)" required autofocus
                            autocomplete="num_chamado" />
                        <x-input-error class="mt-2" :messages="$errors->get('num_chamado')" />
                    </div>

                    <!-- Campo para título do chamado -->
                    <div>
                        <x-input-label class="form-label" for="titulo" :value="__('Titulo do Chamado: ')" />
                        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full form-control"
                            :value="old('titulo', $avaliacao->titulo)" required autofocus autocomplete="titulo" />
                        <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
                    </div>

                    <!-- Campo para selecionar o cliente -->
                    <div>
                        <x-input-label class="form-label" for="cliente" :value="__('Cliente')" />
                        <select id="cliente" name="cliente" class="mt-1 block w-full form-control" required>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ $cliente->id == old('cliente', optional($avaliacao->cliente)->id) ? 'selected' : '' }}>
                                    {{ $cliente->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('cliente')" />
                    </div>

                    <!-- Botão de submit -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success ps-5 pe-5 mt-3">Salvar</button>
                    </div>
                </form>


            </div>
        </div>
        <div class="d-flex gap-2">
            <div>
                @auth
                    @if (auth()->user()->role === 'COORDENADOR')
                        <form method="POST" action="{{ route('avaliacoes.destroy', $avaliacao->id) }}"
                            onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    @endif

                @endauth
            </div>
            <div>
                @if ($avaliacao->avaliacao)
                    <p>Chamado avaliado</p>
                @else
                    <button class="btn btn-success">Editar</button>
                @endif
            </div>
        </div>
    </main>

@endsection

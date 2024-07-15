@extends('layouts.main')

@section('title', 'Usuário')

@section('head')
    <link rel="stylesheet" href="/css/usuarios.css">
@endsection

@section('content')
@php
    use App\Models\Cliente;
@endphp

    <main class="container">
        @if (session('status'))
            <div class="d-flex justify-content-center align-middle alert alert-primary text-center">
                <p>{{ session('status') }}</p>
            </div>
        @endif
        <div class="d-flex">
            <div class="d-flex">
                <div id="nameUser" class="align-items-center">
                    <div class="d-flex">
                        <h3 class="mt-4 ms-4" id="nome">{{ $users->name }}</h3>
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
            </div>
            <div id="nameConfigContainer" class="align-items-center mt-4 ms-4 " style="display: none;">
                <form action="{{ route('user.updateName', ['id' => $users->id]) }}" method="post" class="d-flex gap-2">
                    @csrf
                    @method('PUT')
                    <h3>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $users->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </h3>
                    <div class="d-flex align-items-center gap-1">
                        <button class="btn btn-success p-1" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-check-lg" viewBox="0 0 16 17">
                                <path
                                    d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                            </svg>
                        </button>
                        <button class="btn btn-danger p-1" type="button" onclick="toggleNameConfigCancel()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-x-lg" viewBox="0 0 16 17">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1-.708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex ms-auto">
            <span class="z-n1 alert alert-success d-flex align-items-center ms-auto me-5">{{ $users->score }} Pontos</span>
        </div>

        <div class="row mb-3">
            <div class="col-auto text-end">
                <div><strong>Nome de usuário:</strong></div>
                <div class="mt-2"><strong>E-mail:</strong></div>
                <div class="mt-2"><strong>Cliente:</strong></div>
                <div class="mt-2"><strong>Perfil:</strong></div>
                <div class="mt-2"><strong>Ramal:</strong></div>

            </div>
            <div id="infoUser" class="col">
                <div>{{ $users->username }}</div>
                <div class="mt-2">{{ $users->email }}</div>
                <div class="mt-2">
                    @php
                    $clienteIds = explode(',', $users->cliente_id);
                    $nomesClientes = [];

                    foreach ($clienteIds as $clienteId) {
                        $cliente = Cliente::find($clienteId);
                        if ($cliente) {
                            $nomesClientes[] = $cliente->name;
                        }
                    }
                @endphp
                {{ implode('/ ', $nomesClientes) }}
                </div>
                <div class="mt-2">{{ $users->grupo->name }}</div>
                <div class="mt-2">{{ $users->ramal }}</div>
            </div>
            
            
            
            
            <div id="confiUser" class="col">
                <div class="d-flex flex-column">
                    <div>{{ $users->username }}</div>
                    <div class="d-flex flex-column">
                        <form action="{{ route('user.updateUser', ['id' => $users->id]) }}" method="post">
                            @csrf
                            @method('PUT')

                            <input type="email" id="email" name="email" value="{{ old('email', $users->email) }}"
                                required><br>
                            <div class="d-flex mt-2 gap-2">
                                @foreach ($clientes as $cliente)
                                    <x-checkbox-input name="cliente[]" value="{{ $cliente->id }}"
                                        :checked="in_array($cliente->id, old('cliente', []))">{{ $cliente->name }}</x-checkbox-input>
                                @endforeach
                            </div>

                            <select id="role" name="role" class="block w-full mt-2" required autocomplete="role">
                                <option value="ATENDENTE" {{ old('role') === 'ATENDENTE' ? 'selected' : '' }}>Atendente
                                </option>
                                <option value="COORDENADOR" {{ old('role') === 'COORDENADOR' ? 'selected' : '' }}>
                                    Coordenador</option>
                                <option value="PERFIL_DE_QUALIDADE"
                                    {{ old('role') === 'PERFIL_DE_QUALIDADE' ? 'selected' : '' }}>Perfil
                                    de Qualidade</option>
                            </select><br>
                            <input type="text" id="ramal" name="ramal" class="mt-2"
                                value="{{ old('ramal', $users->ramal) }}"><br>

                            <button type="submit" class="btn btn-success mt-2">Salvar</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        @auth
            @if (auth()->user()->role === 'COORDENADOR')
                <div>
                    <a href="javascript:void(0);" class="btn btn-success">Editar</a>
                </div>
            @endif
        @endauth


        <div class="table-responsive mt-5">
            <h4>Histórico de chamados</h4>
            <table class="table table-striped table-sm text-center text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Atendente</th>
                        <th>Cliente</th>
                        <th>Protocolo de Atendimento</th>
                        <th>Iniciado por</th>
                        <th>Registro</th>
                        <th>Avaliação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($avaliacao as $avaliacao)
                        @if ($avaliacao->id_user == $users->id)
                            <tr>
                                <td><a href="/avaliacoes/details_avaliacao/{{ $avaliacao->id }}">{{ $avaliacao->id }}</a>
                                </td>
                                <td>{{ $avaliacao->id_user ? $avaliacao->user->name : 'Não definido' }}</td>
                                <td>{{ $avaliacao->cliente ? $avaliacao->cliente->name : 'Não definido' }}</td>
                                <td>{{ $avaliacao->num_chamado }}</td>
                                <td>{{ $avaliacao->usuario }}</td>
                                <td>{{ $avaliacao->created_at }}</td>
                                <td>{{ $avaliacao->avaliacao }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

@endsection

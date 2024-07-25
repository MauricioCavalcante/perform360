@extends('layouts.main')

@section('title', 'Usuários')

@section('head')
    <link rel="stylesheet" href="/css/usuarios.css">
@endsection

@section('content')
    @php
        use App\Models\Client;
    @endphp
    
    <main class="container pagina-usuarios">
        <section class="container pagina-usuarios">
            <div class="pagina-questionarios">
                <h1 class="p-3">Questionários</h1>
                <div class="d-flex justify-content-between align-items-center">
                    <form action="{{ route('users.panel_questionnaires') }}" method="GET" class="d-flex">
                        <div class="d-flex align-items-center gap-2 p-3">
                            <x-input-label class="form-label" for="client_id" :value="__('Cliente:')" /> <!-- Corrigido para 'client_id' -->
                            <select id="client_id" name="client_id" class="form-control">
                                <option value="">Todos os clientes</option>
                                @foreach ($client as $client) 
                                    <option value="{{ $client->id }}"
                                        {{ $client->id == $filterClientId ? 'selected' : '' }}> <!-- Corrigido para 'filterClientId' -->
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('client_id')" /> <!-- Corrigido para 'client_id' -->
                            <button type="submit" class="btn btn-dark m-3">Filtrar</button>
                        </div>
                    </form>
                    <div>
                        <strong>Soma das Notas: {{ $totalScore }} /100</strong> <!-- Corrigido para 'totalScore' -->
                        <a href="{{ route('questions.create') }}" class="btn btn-dark m-3">Adicionar Pergunta</a> <!-- Corrigido para 'questions.create' -->
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('danger'))
                    <div class="alert alert-danger text-center">
                        <p>{{ session('danger') }}</p>
                    </div>
                @endif

                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Pergunta</th>
                            <th>Nota</th>
                            <th>Cliente</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question) 
                            <tr>
                                <td>{{ $question->question }}</td>
                                <td class="text-center">{{ $question->score }}</td> 
                                <td class="text-center">
                                    @php
                                        $clientIds = explode('/', $question->client_id);
                                        $clientNames = [];
                                        foreach ($clientIds as $clientId) {
                                            $client = Client::find($clientId);
                                            if ($client) {
                                                $clientNames[] = $client->name;
                                            }
                                        }
                                    @endphp
                                    {{ implode('/ ', $clientNames) }} 
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-success text-decoration-none text-white">Editar</a> 
                                        <form action="{{ route('questions.destroy', $question->id) }}"
                                            method="POST" style="display: inline-block;"
                                            onsubmit="return confirm('Você tem certeza que deseja excluir esta pergunta?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection

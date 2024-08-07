@extends('layouts.main')

@section('title', 'Questionário')

@section('head')
    <link rel="stylesheet" href="/css/questionnaire.css">
@endsection

@section('content')
    @php
        use App\Models\Client;
    @endphp

    <main>
        <section class="container-custom container mb-4 p-4">
            <div class="container">
                <h1 class="p-3">Questionários</h1>
                <div class="d-flex align-items-center">
                    <form action="{{ route('questionnaires.index') }}" method="GET">
                        <div class="d-flex align-items-center gap-2">
                            <x-input-label class="form-label" for="client_id" :value="__('Cliente:')" />
                            <select id="client_id" name="client_id" class="form-control">
                                <option value="">Todos os clientes</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $client->id == $filterClientId ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('client_id')" />
                            <button type="submit" class="btn btn-dark m-3">Filtrar</button>
                        </div>
                    </form>
                    <div class="ms-auto">
                        {{-- <strong>Soma das Notas: {{ $totalScore }} /100</strong> --}}
                        <a href="{{ route('questionnaires.form') }}" class="btn btn-dark m-3">Adicionar Pergunta</a>
                    </div>
                </div>
                {{-- Dentro da sua view panel.blade.php --}}
                <ul class="list-group m-3 mt-0" style="width: 250px">
                    @if (isset($scoreByClientJson))
                        @php
                            $scoreByClientArray = json_decode($scoreByClientJson, true);
                        @endphp
                
                        @if (count($scoreByClientArray) > 0)
                            @foreach ($scoreByClientArray as $clientId => $totalScore)
                                @php
                                    $client = $clients->firstWhere('id', $clientId);
                                    $scoreClass = ($totalScore > 100) ? 'text-danger' : (($totalScore < 100) ? 'text-danger' : '');
                                @endphp
                                <li class="list-group-item">
                                    @if ($client)
                                        {{ $client->name }} - Pontuação: <span class="{{ $scoreClass }}">{{ $totalScore }}</span>
                                    @else
                                        Cliente não encontrado para ID: {{ $clientId }}
                                    @endif
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item">Nenhum dado disponível.</li>
                        @endif
                    @endif
                </ul>
                
            
            

            </div>
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger text-center">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            <table class="table table-striped align-middle">
                <thead>
                    <tr class="table-dark">
                        <th>Pergunta</th>
                        <th class="text-center">Nota</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <td>{{ $question->question }}</td>
                            <td class="text-center">{{ $question->score }}</td>
                            <td class="text-center">
                                @php
                                    $clientIds = json_decode($question->client_id);
                                    $clientNames = [];
                                    foreach ($clientIds as $clientId) {
                                        $client = Client::find($clientId);
                                        if ($client) {
                                            $clientNames[] = $client->name;
                                        }
                                    }
                                @endphp
                                {{ implode(' / ', $clientNames) }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('questionnaires.edit', ['id' => $question->id]) }}"
                                        class="btn btn-sm btn-primary text-decoration-none text-white">Editar</a>
                                    <form action="{{ route('questionnaires.delete', $question->id) }}" method="POST"
                                        style="display: inline-block;"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta pergunta?');">
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

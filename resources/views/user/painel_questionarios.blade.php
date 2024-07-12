@extends('layouts.main')

@section('title', 'Usuários')

@section('head')
    <link rel="stylesheet" href="/css/usuarios.css">
@endsection

@section('content')
    @php
        use App\Models\Cliente;
    @endphp

    <main class="container pagina-usuarios">

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

            <div class="pagina-questionarios">
                <h1 class="p-3">Questionários</h1>
                <div class="d-flex justify-content-between align-items-center">
                    <form action="{{ route('user.painel_questionarios') }}" method="GET" class="d-flex">
                        <div class="d-flex align-items-center gap-2 p-3">
                            <x-input-label class="form-label" for="cliente_id" :value="__('Cliente:')" />
                            <select id="cliente_id" name="cliente_id" class="form-control">
                                <option value="">Todos os clientes</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ $cliente->id == $filtroClienteId ? 'selected' : '' }}>
                                        {{ $cliente->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('cliente_id')" />
                            <button type="submit" class="btn btn-dark m-3">Filtrar</button>
                        </div>
                    </form>
                    <div>
                        <strong>Soma das Notas:</strong>
                        <strong>{{ $somaDasNotas }}</strong>
                        <a href="{{ route('questionarios.create') }}" class="btn btn-dark m-3">Adicionar Pergunta</a>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pergunta</th>
                            <th>Nota</th>
                            <th>Cliente</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questionarios as $questionario)
                            <tr>
                                <td>{{ $questionario->id }}</td>
                                <td>{{ $questionario->pergunta }}</td>
                                <td class="text-center">{{ $questionario->nota }}</td>
                                <td class="text-center">
                                    @php
                                        $clienteIds = explode(',', $questionario->cliente_id);
                                        $nomesClientes = [];
                                        foreach ($clienteIds as $clienteId) {
                                            $cliente = Cliente::find($clienteId);
                                            if ($cliente) {
                                                $nomesClientes[] = $cliente->name;
                                            }
                                        }
                                    @endphp
                                    {{ implode('/ ', $nomesClientes) }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('questionarios.edit', $questionario->id) }}"
                                            class="btn btn-sm btn-success text-decoration-none text-white">Editar</a>
                                        <form action="{{ route('questionarios.delete', $questionario->id) }}" method="POST"
                                            style="display: inline-block;">
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

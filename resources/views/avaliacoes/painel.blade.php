@extends('layouts.main')

@section('title', 'Avaliações')

@section('content')

    <main class="container pagina-chamados">
        <h3 class="m-4">Avaliações registradas</h3>
        <!-- Display success message -->
        @if (session('success'))
        <div class="d-flex justify-content-center align-middle alert alert-primary text-center">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        @if (session('warning'))
        <div class="d-flex justify-content-center align-middle alert alert-warning text-center">
            <p>{{ session('warning') }}</p>
        </div>
        @endif
        @if (session('error'))
        <div class="d-flex justify-content-center align-middle alert alert-danger text-center">
            <p>{{ session('error') }}</p>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr class='align-middle text-nowrap text-center'>
                        <th>ID_Avaliação</th>
                        <th>Cliente</th>
                        <th>Registro</th>
                        <th>Avaliação</th>
                        <th>FeedBack</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($avaliacoes as $avaliacao)
                        <tr class="text-center align-middle">
                            <td>{{ $avaliacao->id }}</td>
                            <td>
                                @if ($avaliacao->audio)

                                        <a href="/avaliacoes/details_avaliacao/{{ $avaliacao->id }}" class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                            @isset($avaliacao->cliente)
                                                {{ $avaliacao->cliente->name ?? 'Cliente sem nome' }}
                                            @else
                                                <p>Não definido</p>
                                            @endisset
                                        </a>
                                @else
                                    <p>Nenhum áudio disponível.</p>
                                @endif
                            </td>
                            <td>
                                {{ $avaliacao->created_at }}
                            </td>
                            <td>
                                {{ $avaliacao->avaliacao }}
                            </td>
                            <td>
                                {{ $avaliacao->feedback }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma avaliação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
@endsection

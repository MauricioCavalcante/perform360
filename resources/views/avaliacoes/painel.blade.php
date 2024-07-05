@extends('layouts.main')

@section('title', 'Avaliações')

@section('content')

    <main class="container pagina-chamados">
        <h3 class="m-4">Avaliações registradas</h3>
        <!-- Display success message -->
        @if (session('success'))
        <div class="d-flex justify-content-center alert alert-success text-center">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr class='align-middle text-nowrap text-center'>
                        <th>ID_Avaliação</th>
                        <th>Áudio</th>
                        <th>Registro</th>
                        <th>Avaliação</th>
                        <th>FeedBack</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($avaliacoes as $avaliacao)
                        <tr class="text-center align-middle">
                            <td><a href="/avaliacoes/details_avaliacao/{{ $avaliacao->id }}">{{ $avaliacao->id }}</a></td>
                            <td>
                                @if ($avaliacao->audio)
                                        {{$avaliacao->audio}}
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

@extends('layouts.main')

@section('title', 'Avaliações')

@section('head')
    <link rel="stylesheet" href="/css/evaluation.css">
@endsection

@section('content')
 
    <main class="container-custom container">
        <div class="d-flex">
            <div>
                <h3 class="m-4">Avaliações registradas</h3>
            </div>
            <div class="mt-3 p-2 ms-auto me-5 alert alert-secondary">
                <h6 class="mt-2">Media avaliações: {{ $avgScore }}</h6>
            </div>
        </div>
        <hr>
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
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr class='align-middle text-nowrap text-center'>
                        <th>ID</th>
                        <th>Atendente</th>
                        <th>Cliente</th>
                        <th>Registro</th>
                        <th>Avaliação</th>
                        <th>FeedBack</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($evaluation as $evaluation)
                        <tr class="text-center align-middle">
                            <td>{{ $evaluation->id }}</td>
                            <td>
                                @isset($evaluation->user_id)
                                    @if (Auth::user()->group_id == 2 || Auth::user()->group_id == 1)
                                        <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                            href="{{ route('users.panel_users_details', ['id' => $evaluation->user->id]) }}">{{ $evaluation->user->name ?? 'Atendente não encontrado' }}</a>
                                    @else
                                        {{ $evaluation->user->name ?? 'Atendente não encontrado' }}
                                    @endif
                                @else
                                    Não atribuído
                                @endisset
                            </td>
                            <td>
                                @isset($evaluation->client_id)
                                    <a href="{{ route('evaluations.details_evaluation', ['id' => $evaluation->id]) }}"
                                        class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                        {{ $evaluation->client->name ?? 'Cliente sem nome' }}
                                    </a>
                                @else
                                    <a href="{{ route('evaluations.details_evaluation', ['id' => $evaluation->id]) }}"
                                        class="alert alert-warning p-1 link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                        Não definido
                                    </a>
                                @endisset
                            </td>
                            <td>
                                {{ $evaluation->created_at }}
                            </td>
                            <td>
                                @isset($evaluation->client_id)
                                    <a href="{{ route('evaluations.details_evaluation', ['id' => $evaluation->id]) }}"
                                        class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                        {{ $evaluation->score ?? 'Avaliar' }}
                                    </a>
                                @else
                                    <a href="{{ route('evaluations.details_evaluation', ['id' => $evaluation->id]) }}"
                                        class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                        Categorizar
                                    </a>
                                @endisset
                            </td>
                            <td>{{ $evaluation->feedback }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma avaliação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{$pagination->links()}}
        </div>
    </main>
@endsection

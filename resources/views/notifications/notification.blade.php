@extends('layouts.main')

@section('title', 'Notificações')

@section('head')
    <link rel="stylesheet" href="/css/novo_chamado.css">
@endsection

@section('content')
    <main class="container">
        <h3 class="m-5">Notificações de Avaliações</h3>

        @if ($notifications->isEmpty())
            <div class="d-flex m-5">
                <p>Nenhuma notificação encontrada.</p>
            </div>
        @else
            @foreach ($notifications as $notification)
                <div class="d-flex align-items-center alert alert-light d-flex gap-3" role="alert">
                    {{ $notification->notification }}
                    @if ($notification->notification)
                        <a href="{{ route('evaluations.details_evaluation', ['id' => $notification->evaluation_id]) }}">Ver avaliação.</a>
                        @if ($notification->reading == '0')
                            <div class="ms-auto">
                                <form action="{{ route('notification.reading', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-light p-1">Marcar como lida</button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        @endif
    </main>
@endsection

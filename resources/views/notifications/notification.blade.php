@extends('layouts.main')

@section('title', 'Notificações')

@section('head')
    <link rel="stylesheet" href="/css/novo_chamado.css">
@endsection

@section('content')
    <main class="container container-custom">
        <div class="d-flex">
            <div class="m-5">
                <h3>Notificações</h3>
            </div>
            <div class="ms-auto mt-auto mb-3">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <a href="{{ route('notifications.index', ['type' => 'all']) }}" 
                       class="btn btn-outline-dark {{ $type === 'all' ? 'active' : '' }}">Todas</a>
                    <a href="{{ route('notifications.index', ['type' => 'Transcription']) }}" 
                       class="btn btn-outline-dark {{ $type === 'Transcription' ? 'active' : '' }}">Transcrição</a>
                    <a href="{{ route('notifications.index', ['type' => 'Revision']) }}" 
                       class="btn btn-outline-dark {{ $type === 'Revision' ? 'active' : '' }}">Revisão</a>
                </div>
            </div>
        </div>

        @if ($notifications->isEmpty())
            <div class="d-flex m-5">
                <p>Nenhuma notificação encontrada.</p>
            </div>
        @else
            @foreach ($notifications as $notification)
                <div class="d-flex align-items-center alert alert-light d-flex gap-3" role="alert">
                    {{ $notification->notification }}
                    @if ($notification->evaluation_id)
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

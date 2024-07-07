@extends('layouts.main')

@section('title', 'Notificações')

@section('head')
    <link rel="stylesheet" href="/css/novo_chamado.css">
@endsection

@section('content')
    <main class="container">
        <h3 class="m-5">Notificações de Avaliações</h3>

        @if ($notifications->isEmpty())
            <div class="m-5">
                <p>Nenhuma notificação encontrada.</p>
            </div>
        @else
            @foreach ($notifications as $notification)
                <div class="alert alert-light d-flex gap-3" role="alert">
                    {{ $notification->notification }}
                    @if ($notification->avaliacao)
                        <a href="/avaliacoes/details_avaliacao/{{ $notification->avaliacao->id }}">Ver avaliação.</a>
                    @endif
                </div>
            @endforeach
        @endif
    </main>
@endsection

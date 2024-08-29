@extends('layouts.main')

@section('title', 'Avisos')

@section('head')
    <link rel="stylesheet" href="/css/warning.css">
@endsection

@section('content')
    <main class="container-custom container">
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

        @if (Auth::user()->group_id === 2 || Auth::user()->group_id === 1)
            <aside class="d-flex justify-content-end">
                <a href="{{ route('warnings.create') }}" class="btn btn-dark">Novo aviso</a>
            </aside>
        @endif

        <section>
            <div class="text-center">
                <h3>Quadro de Avisos</h3>
            </div>
            @if ($warnings->isEmpty())
                <div class="d-flex m-5">
                    <p>Sem avisos.</p>
                </div>
            @else
                <div class="d-flex row justify-content-center gap-2">
                    @foreach ($warnings as $warning)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card" style="width: 18rem;">
                                @if ($warning->image)
                                    <img src="{{ asset('storage/' . $warning->image) }}" class="card-img-top"
                                        alt="Imagem {{ $warning->title }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $warning->title }}</h5>
                                    <p class="card-text">{!! $warning->body !!}</p>
                                </div>
                                <div>
                                    @if ($warning->start && $warning->finish)
                                        <div class="d-flex">
                                            <div class="ms-auto me-auto">
                                                <strong>
                                                    <div id="countdown-{{ $warning->id }}" class="countdown">
                                                    </div>
                                                </strong>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <form action="{{ route('warnings.destroy', $warning->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja deletar este aviso?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Deletar aviso">
                                            <!-- Ícone de deletar -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                            </svg>
                                        </button>
                                    </form>
                                    <a href="{{ route('warnings.edit', $warning->id) }}" class="btn btn-primary">Editar</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($warnings as $warning)
                @if ($warning->finish)
                    const countdownElement{{ $warning->id }} = document.getElementById('countdown-{{ $warning->id }}');
                    const finishDate{{ $warning->id }} = new Date("{{ $warning->finish }}");

                    function updateCountdown{{ $warning->id }}() {
                        const now = new Date();
                        const timeLeft = finishDate{{ $warning->id }} - now;

                        if (isNaN(finishDate{{ $warning->id }}.getTime()) || timeLeft < 0) {
                            countdownElement{{ $warning->id }}.innerHTML = 'Tempo esgotado!';
                            return;
                        }

                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        countdownElement{{ $warning->id }}.innerHTML =
                            `${days} d ${hours} h ${minutes} min ${seconds} seg`;
                    }

                    // Atualiza a contagem regressiva a cada segundo
                    setInterval(updateCountdown{{ $warning->id }}, 1000);

                    // Atualiza imediatamente ao carregar a página
                    updateCountdown{{ $warning->id }}();
                @endif
            @endforeach
        });
    </script>
@endsection

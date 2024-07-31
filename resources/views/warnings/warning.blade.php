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
        <section>
            @if ($warnings->isEmpty())
                <div class="d-flex m-5">
                    <p>Sem avisos.</p>
                </div>
            @else
                <div class="text-center">
                    <h3>AVISOS</h3>
                </div>
                <div id="carouselWarning" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="20000">
                    <!-- Indicadores do carrossel -->
                    <div class="carousel-indicators">
                        @foreach ($warnings as $index => $warning)
                            <button type="button" data-bs-target="#carouselWarning"
                                data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    <!-- Conteúdo do carrossel -->
                    <div class="carousel-inner">
                        @foreach ($warnings as $index => $warning)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $warning->image) }}" class="d-block"
                                    alt="Imagem {{ $warning->title }}">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{ $warning->title }}</h5>
                                    <p>{{ $warning->body }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Controles do carrossel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselWarning"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous slide</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselWarning"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next slide</span>
                    </button>
                </div>
            @endif
        </section>
    </main>
@endsection
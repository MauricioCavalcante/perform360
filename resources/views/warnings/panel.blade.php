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
            @if ($warnings->isEmpty())
                <div class="d-flex m-5">
                    <p>Sem avisos.</p>
                </div>
            @else
                <div class="text-center">
                    <h3>Quadro de Avisos</h3>
                </div>
                <div class="d-flex gap-2">
                    @foreach ($warnings as $warning)
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('storage/' . $warning->image) }}" class="card-img-top" alt="Imagem {{ $warning->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $warning->title }}</h5>
                                <p class="card-text">{{ $warning->body }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
@endsection

@extends('layouts.main')

@section('title', 'Home')

@section('head')
    <link rel="stylesheet" href="/css/dashboard.css">
@endsection

@section('content')
    @if (session('error'))
        <div class="d-flex justify-content-center align-middle alert alert-danger text-center">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    <main class="m-3 d-flex justify-content-center align-items-center">
        <section class="dashboard">
            <h3 class="text-center p-2">Central Hitss - Dashboard</h3>
            <div class="dashboardCard container d-flex gap-5 justify-content-center">
                <div class="cardEvaluations text-center">
                    <p class="mt-2">Total de avaliações:</p>
                    <p class="fs-3">{{ $totalEvaluation }}</p>
                </div>
                <div class="cardScore text-center">
                    <p class="mt-2">Média Geral:</p>
                    <p class="fs-3">{{ $score }}</p>
                </div>
                <div class="cardFristPosition text-center">
                    <p class="mt-2">Avaliados:</p>
                    <p class="fs-3">{{ $countEvaluation }}</p>
                </div>

            </div>
        </section>
    </main>
@endsection

@extends('layouts.main')

@section('title', 'Home')

@section('head')
    <link rel="stylesheet" href="/css/dashboard.css">

    {{-- Scripts --}}
    <script src="/js/chart.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('content')
    @if (session('error'))
        <div class="d-flex justify-content-center align-middle alert alert-danger text-center">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    <main class="row gap-1 container-custom d-flex m-auto overflow-auto">
        <section class="col-auto container-custom container m-auto">
            <h3 class="text-center p-2">Perform360 - Dashboard</h3>
            <div>
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
            </div>
            <div class="row">
                <div class="mt-5 col-auto" id="container" data-chart-data='@json($data)'></div>
                <div class="mt-5 col-auto" id="history" data-chart-data="{{ $generalAverageData }}|{{ $clientAverageData }}"></div>

            </div>

        </section>
        <aside class="col-auto container-custom container">
            <div class="flex-shrink-1 border border-secondary rounded m-auto align">
                <h4 class="text-center m-auto">Classificação</h4>
                <div class="table-responsive m-2 p-2">
                    <table class="table table-striped table-bordered table-sm ">
                        <thead class="">
                            <tr class='text-center text-nowrap'>
                                <th>Classificação</th>
                                <th>Nome</th>
                                <th>Pontuação</th>
                                <th>Avaliações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $users = $users->sortByDesc(function ($user) use ($averageScores) {
                                    foreach ($averageScores as $averageScore) {
                                        if ($averageScore->user_id == $user->id) {
                                            return $averageScore->average_score;
                                        }
                                    }
                                    return 0;
                                });
                            @endphp
                            @foreach ($users as $user)
                                <tr class="text-center text-nowrap align-middle ">
                                    <td>{{ $loop->iteration }}º</td>
                                    <td>
                                        <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                            href="{{ route('users.panel_users_details', ['id' => $user->id]) }}">
                                            {{ explode(' ', $user->name)[0] }}
                                        </a>
                                    </td>
                                    <td>
                                        @foreach ($averageScores as $averageScore)
                                            @if ($averageScore->user_id == $user->id)
                                                {{ number_format($averageScore->average_score, 1) }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($countEvaluationUser as $evaluation)
                                            @if ($evaluation->user_id == $user->id)
                                                {{ $evaluation->total }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </aside>
    </main>
@endsection

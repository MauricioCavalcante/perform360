@extends('layouts.main')

@section('title', 'Detalhes da Avaliação')

@section('content')
    <main class="container-custom container">
        <section class="container ms-5">
            <h2>Avaliação - {{ $evaluation->id }}</h2>
            <span><strong>Pontuação:</strong> {{ $evaluation->score }}</span><br>
            <span><strong>Comentário:</strong> {{ $evaluation->feedback }}</span><br>
            <span><strong>Avaliado em:</strong> {{ $evaluation->created_at }}</span>
        </section>
        <section class="container-custom">
            <h3>Perguntas e Respostas</h3>
            <ol>
                @foreach ($questionnaires as $questionnaire)
                    <li>
                        <div class="d-flex justify-content-between align-items-center">
                            <p><strong>Pergunta:</strong> {{ $questionnaire->question }}</p>
                            <p>
                                @if ($questionnaire->response == 'Sim')
                                    <span class="alert alert-success p-1">{{ $questionnaire->response }}</span>
                                @else
                                    <span class="alert alert-danger p-1">{{ $questionnaire->response }}</span>
                                @endif
                            </p>
                        </div>
                    </li>
                    <hr>
                @endforeach
            </ol>
        </section>
    </main>
@endsection

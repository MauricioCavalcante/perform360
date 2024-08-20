@extends('layouts.main')

@section('title', 'Avaliar')

@section('head')
    <link rel="stylesheet" href="/css/evaluation.css">
@endsection

@section('content')
    @if (session('warning'))
        <div class="d-flex justify-content-center align-middle alert alert-warning text-center">
            <p>{{ session('warning') }}</p>
        </div>
    @endif
    <main>
        <div class="container-custom container">
            <div class="container">
                <div>
                    <h1>Detalhes da Avaliação</h1>
                </div>
                <div class="d-flex">
                    <div>
                        <h6>Avaliação ID: {{ $evaluation->id }}</h6>
                        <h6>Cliente: {{ $evaluation->client->name }}</h6>
                        <h6>Atendente: {{ $evaluation->user->name }}</h6>
                    </div>
                    <div class="ms-auto me-5 mt-auto alert alert-primary pb-0 p-1">
                        <h6>Pontuação: <span id="currentValue">100</span></h6>
                    </div>
                </div>
            </div>

            <div class="m-4 mt-5">
                <p>Perguntas:</p>
                <form action="{{ route('questionnaires.save', ['id' => $evaluation->id]) }}" method="post">
                    @csrf
                    <ol>
                        @foreach ($questions as $question)
                            <li>
                                <div class="container border-secondary row d-flex align-items-center justify-content-end {{ $question->deduction == 1 ? 'deduction' : '' }}"
                                    data-question-id="{{ $question->id }}" data-question-score="{{ $question->score }}">
                                    @if ($question->deduction == 1)
                                        <div class="col-auto alert alert-danger p-1 m-1">
                                            Importante!
                                        </div>
                                    @else
                                        <div class="col-auto alert alert-light p-1 m-1">
                                            Nota: {{ $question->score }}
                                        </div>
                                    @endif
                                    <div class="col">
                                        <label>{{ $question->question }}</label>
                                        <input type="hidden" name="questions[{{ $question->id }}][question]"
                                            value="{{ $question->question }}">
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input score" type="radio"
                                                name="questions[{{ $question->id }}][response]"
                                                id="score_{{ $question->id }}_sim1" value="{{ $question->score }}"
                                                checked>
                                            <label class="form-check-label"
                                                for="score_{{ $question->id }}_sim1">Sim</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input score" type="radio"
                                                name="questions[{{ $question->id }}][response]"
                                                id="score_{{ $question->id }}_nao2" value="0">
                                            <label class="form-check-label"
                                                for="score_{{ $question->id }}_nao2">Não</label>
                                        </div>
                                        <input type="hidden" name="questions[{{ $question->id }}][score]"
                                            value="{{ $question->score }}">
                                        <input type="hidden" name="questions[{{ $question->id }}][deduction]"
                                            value="{{ $question->deduction }}">
                                    </div>
                                </div>
                            </li>
                            <hr>
                        @endforeach
                    </ol>
                    <div>
                        <input type="hidden" id="totalScore" name="totalScore" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="feedback" class="form-label">Comentário</label>
                        <textarea class="form-control" name="feedback" id="feedback" cols="15" rows="5"></textarea>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-dark w-50" type="submit">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="/js/evaluation.js"></script>
@endsection

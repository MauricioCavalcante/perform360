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
        <div class="container questionnaire">
            <div class="d-flex ">
                <div class="d-flex justify-content-end align-items-center">
                    <h1>Detalhes da Avaliação</h1>
                </div>
                <div class="ms-auto me-5 mt-auto">
                    <h6>Pontuação: <span id="currentValue">100</span></h6>
                </div>
            </div>
            <h6>Avaliação ID: {{ $evaluation->id }}</h6>
            <h6>Cliente: {{ $evaluation->client->name }}</h6>
            <div class="m-4 mt-5">
                <p>Perguntas:</p>
                <form action="{{ route('evaluations.save', ['id' => $evaluation->id]) }}" method="post">
                    @csrf
                    <ol>
                        @foreach ($questions as $question)
                            <li>
                                <div class="container border-secondary row d-flex align-items-center justify-content-end">
                                    <div class="col-auto alert alert-light p-1 m-1">
                                        Nota: {{ $question->score }}
                                    </div>
                                    <div class="col">
                                        <label>{{ $question->question }}</label>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input score" type="radio"
                                                name="score[{{ $question->id }}]" id="score_{{ $question->id }}_sim1"
                                                value="{{ $question->score }}" checked>
                                            <label class="form-check-label" for="score_{{ $question->id }}_sim1">Sim</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input score" type="radio"
                                                name="score[{{ $question->id }}]" id="score_{{ $question->id }}_nao2"
                                                value="0">
                                            <label class="form-check-label" for="score_{{ $question->id }}_nao2">Não</label>
                                        </div>
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

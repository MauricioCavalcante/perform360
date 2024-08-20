@extends('layouts.main')

@section('title', 'Detalhes da Avaliação')

@section('content')
    <main class="container-custom container">
        <section class="container ms-5 d-flex">
            <div>
                <h2>Avaliação - {{ $evaluation->id }}</h2>
                <span><strong>Pontuação: </strong>{{ $evaluation->score }}</span><br>
                <span><strong>Comentário:</strong> {{ $evaluation->feedback }}</span><br>
                <span><strong>Avaliado em:</strong> {{ $evaluation->created_at }}</span>
            </div>
            <div class="ms-auto me-5 mt-auto d-flex gap-2">
                @if (Auth::user()->group_id == 2 || Auth::user()->group_id == 1)
                    <div>
                        <button id="edit-btn" type="button" class="btn btn-success">Editar</button>
                        
                    </div>
                @endif
                <div>
                    @if ($evaluation->revision_requested)
                        <button type="button" class="btn btn-dark" disabled>Revisão Solicitada</button>
                    @else
                        <form action="{{ route('evaluation.revision', $evaluation->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-dark">Solicitar Revisão</button>
                        </form>
                    @endif
                </div>
            </div>
        </section>
        <section class="container-custom">
            <div>
                <h3>Perguntas e Respostas</h3>
            </div>
            <form id="edit-form" action="{{ route('questionnaires.update', $evaluation->id) }}" method="post"
                style="display: none;">
                @csrf
                <div class="d-flex gap-2">
                    <div class="ms-auto p-1 alert alert-primary">
                        <span>Pontuação: </span>
                        <span id="currentValue"></span>
                    </div>
                    <div>
                        <button id="cancel-edit-btn" type="button" class="btn btn-secondary p-1">Cancelar</button>
                    </div>
                </div>
                <ol>
                    @foreach ($questionnaires as $questionnaire)
                        <li>
                            <div class="container border-secondary row d-flex align-items-center justify-content-end {{ $questionnaire->deduction == 1 ? 'deduction' : '' }}"
                                data-question-id="{{ $questionnaire->id }}"
                                data-question-score="{{ $questionnaire->score }}">
                                @if ($questionnaire->deduction == 1)
                                    <p><strong class="alert alert-danger p-1" role="alert">Importante!</strong>
                                        {{ $questionnaire->question }}</p>
                                @else
                                    <p><strong class="alert alert-secondary p-1"
                                            role="alert">{{ $questionnaire->score }}</strong>:
                                        {{ $questionnaire->question }}</p>
                                @endif
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input score" type="radio"
                                            name="questions[{{ $questionnaire->id }}][response]"
                                            value="{{ $questionnaire->score }}"
                                            {{ $questionnaire->response == 'Sim' ? 'checked' : '' }}>
                                        <label class="form-check-label">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input score" type="radio"
                                            name="questions[{{ $questionnaire->id }}][response]" value="0"
                                            {{ $questionnaire->response == 'Não' ? 'checked' : '' }}>
                                        <label class="form-check-label">Não</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="questions[{{ $questionnaire->id }}][deduction]"
                                value="{{ $questionnaire->deduction }}">
                            <input type="hidden" name="questions[{{ $questionnaire->id }}][question]"
                                value="{{ $questionnaire->question }}">
                            <input type="hidden" name="questions[{{ $questionnaire->id }}][score]"
                                value="{{ $questionnaire->score }}">
                            <hr>
                        </li>
                    @endforeach
                </ol>
                <input type="hidden" id="totalScore" name="totalScore" value="0">
                <div class="mb-3">
                    <label for="feedback" class="form-label">Comentário</label>
                    <textarea class="form-control" name="feedback" id="feedback" cols="15" rows="5">{{ old('feedback', $evaluation->feedback) }}</textarea>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button id="cancel-edit-btn" type="button" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>


            <ol id="question-list">
                @foreach ($questionnaires as $questionnaire)
                    <li>
                        <div class="d-flex gap-2 justify-content-between align-items-center">
                            <p><strong>Pergunta:</strong> {{ $questionnaire->question }}</p>
                            <p>
                                @if ($questionnaire->response == 'Sim')
                                    <span class="alert alert-success p-1">{{ $questionnaire->response }}</span>
                                @else
                                    <span class="alert alert-danger p-1">{{ $questionnaire->response }}</span>
                                @endif
                            </p>
                        </div>
                        <hr>
                    </li>
                @endforeach
            </ol>
        </section>
    </main>
    <script src="/js/evaluation_edit.js"></script>
@endsection

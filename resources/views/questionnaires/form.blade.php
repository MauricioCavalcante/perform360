@extends('layouts.main')

@section('title', 'Formulário')

@section('head')
    <link rel="stylesheet" href="/css/questionnaire.css">
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger text-center">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success text-center">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <main class="container-custom container">
        <div class="p-5 pt-3">
            <h3>{{ isset($question) ? 'Editar Pergunta' : 'Nova Pergunta' }}</h3>
            <form class="form-group"
                action="{{ isset($question) ? route('questions.update', $question->id) : route('questions.store') }}"
                method="POST">
                @if (isset($question))
                    @method('PUT')
                @endif
                @csrf

                <div class="mt-4 gap-2 d-flex align-items-center btn-group">
                    <x-input-label for="client_id" :value="__('Cliente:')" />
                    <div class="mt-1 d-flex gap-1">
                        @foreach ($clients as $client)
                            <x-checkbox-input name="client_id[]" value="{{ $client->id }}" :checked="in_array($client->id, old('client_id', []))">
                                {{ $client->name }}
                            </x-checkbox-input>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                </div><br>

                <div class="gap-2 d-flex align-items-center btn-group">
                    <x-input-label for="deduction" :value="__('Desconto:')" />
                    <div class="mt-1 radio-group">
                        <label class="p-1">
                            <input type="radio" id="deduction-sim" name="deduction" value="Sim" class="radio-input"
                                {{ old('deduction', isset($question) ? $question->deduction : '') == 'Sim' ? 'checked' : (!isset($question) && old('deduction') == '' ? 'checked' : '') }}
                                required>
                            <span>Sim</span>
                        </label>
                        <label class="p-1">
                            <input type="radio" id="deduction-nao" name="deduction" value="Não" class="radio-input"
                                {{ old('deduction', isset($question) ? $question->deduction : '') == 'Não' || (!isset($question) && old('deduction') == '') ? 'checked' : '' }}
                                required>
                            <span>Não</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('deduction')" class="mt-2" />
                </div><br>

                <label for="question">Pergunta:</label>
                <input type="text" id="question" name="question" class="form-control"
                    value="{{ old('question', isset($question) ? $question->question : '') }}" required><br>

                <div class="d-flex gap-2 align-items-center">
                    <label id="score-label" for="score">Nota:</label>
                    <input type="text" id="score" name="score" class="form-control" style="width: 100px"
                        value="{{ old('score', isset($question) ? $question->score : '') }}" step="any" required><br>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-dark m-3 w-50" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </main>
    <script src="/js/evaluation.js"></script>
@endsection

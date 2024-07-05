@extends('layouts.main')

@section('title', 'Avaliação')


@section('head')
    <link rel="stylesheet" href="/css/novo_chamado.css">
@endsection


@section('content')



    <main class="container">
        <h3 class="m-4">Avaliação - {{$avaliacao->id}}</h3><hr>
        <div class="row">

            <div class="col">
                <div class="row d-flex align-items-center">
                    <h6 class="col-auto">Áudio:</h6>
                    @if ($avaliacao->audio)
                        <audio controls>
                            <source src="{{ Storage::url($avaliacao->audio) }}" type="audio/wav">
                            Seu navegador não suporta áudio HTML5.
                        </audio>
                    @else
                        <p>Nenhum áudio disponível.</p>
                    @endif
                </div>
                <div class="form-floating mt-3">
                    <textarea class="form-control" name="transcricao" id="transcricao" style="display: none;"></textarea>
                </div>
            </div>
            <div class="col">
                <h5>Transcrição</h5>
                @if ($avaliacao->transcricao)
                    <p>{{ $avaliacao->transcricao }}</p>
                @else
                <div class="d-flex m-5">
                    <div class="m-1" id="loader"></div>
                    <p class="ms-2">Transcrição em andamento, aguarde!</p>
                </div>
                @endif
            </div>
        </div>
        <div>
            @if ($avaliacao->avaliacao)
                <p>Chamado avaliado</p>
            @else
                <button class="btn btn-success">Avaliar</button>
            @endif
        </div>
    </main>

@endsection

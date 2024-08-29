@extends('layouts.main')

@section('title', 'Procedimentos')

@section('head')
    <link rel="stylesheet" href="/css/procedure.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
            }
        }
    </script>
@endsection

@section('content')
    <main class="container container-custom">
        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        <details class="p-2 mb-2">
            <summary><strong>Roteiro de ligações</strong></summary>
            <div class="container container-custom">
                <div class="container container-custom treinamento">
                    @if (Auth::user()->group_id == 2 || Auth::user()->group_id == 1)
                        <div class="d-flex gap-2">
                            <button type="button" class="ms-auto m-2 btn btn-dark" data-bs-toggle="modal"
                                data-bs-target="#textModal">
                                Novo Procedimento
                            </button>
                        </div>
                    @endif

                    @foreach ($procedures as $procedure)
                        <div class="d-flex justify-content-center">
                            <div>
                                {!! $procedure->text !!}
                            </div>
                        </div>
                        @if (Auth::user()->group_id == 2 || Auth::user()->group_id == 1)
                            <div class="d-flex align-items-center">
                                <button type="button" class="ms-auto m-2 btn btn-dark btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editTextModal" data-id="{{ $procedure->id }}"
                                    data-text="{{ $procedure->text }}">
                                    Editar
                                </button>
                                <form action="{{ route('procedures.destroy', $procedure->id) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja deletar este procedimento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-auto" title="Deletar procedimento">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                        <!-- Modal para Editar Procedimento -->
                        <div class="modal fade" id="editTextModal" tabindex="-1" aria-labelledby="editTextModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editTextModalLabel">Modificar Texto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('procedures.update', 'id_placeholder') }}" method="POST"
                                            id="edit-form">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <textarea name="procedure" id="edit-procedure" class="ckeditor">{{ old('procedure', $procedure->text) }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Substituir</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    <!-- Modal para Novo Procedimento -->
                    <div class="modal fade" id="textModal" tabindex="-1" aria-labelledby="textModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="textModalLabel">Adicionar Novo Procedimento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('procedures.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <textarea name="procedure" id="procedure" class="ckeditor"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Adicionar</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </details>
        <hr>
        <details class="p-2 mb-2">
            <summary><strong>Treinamentos</strong></summary>
        </details>

    </main>
@endsection
@section('scripts')
    <script type="module" src="/js/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById('editTextModal');

            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var text = button.getAttribute('data-text');
                var id = button.getAttribute('data-id');

                var textarea = document.getElementById('edit-procedure');
                textarea.value = text;

                var form = document.getElementById('edit-form');
                form.action = form.action.replace('id_placeholder', id);
            });
        });
    </script>
@endsection

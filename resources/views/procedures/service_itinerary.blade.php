@extends('layouts.main')

@section('title', 'Procedimentos')

@section('head')
    <link rel="stylesheet" href="/css/procedure.css">
    <style>
        .treinamento {
            height: 1000px;
        }
    </style>
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
            <div class="container- container-custom">

                {{-- <ol>
                    <li>
                        Script de Atendimento
                        <ol>
                            <li>Saudação: <span class="text-danger"><strong>(Obrigatório)</strong></span>
                                <ul>
                                    <li>"Bom dia/Boa tarde/Boa noite, você ligou para Service Desk da
                                        <strong>#ANATEL/ANEEL#</strong> com
                                        quem eu falo?"</li>
                                </ul>
                            </li>
                            <li>Início do Atendimento: <span class="text-danger"><strong>(Obrigatório)</strong></span>
                                <ul>
                                    <li>"<strong>#NOME DO USUÁRIO#</strong> Informamos que esta ligação está sendo gravada
                                        para fins de qualidade e segurança."</li>
                                    <li>Em que posso ajudá-lo?</li>
                                </ul>
                            </li>
                            <li>Coleta de Informações
                                <ul>
                                    <li>Descrição do Problema/Consulta/Detalhamento de problemas/Registro</li>
                                </ul>
                            </li>
                            <li>Registro do Chamado
                                <ol>
                                    <li>Inserção dos Dados no Sistema
                                        <ul>
                                            <li>Registrar todas as informações fornecidas pelo cliente no sistema do cliente
                                                ANATEL/ANEEL.</li>
                                        </ul>
                                    </li>
                                    <li>Confirmação dos Dados:
                                        <ul>
                                            <li>Reconfirmar com o cliente as informações registradas para garantir precisão,
                                                se necessário.</li>
                                        </ul>
                                    </li>
                                </ol>
                            </li>
                            <li>Finalização da ligação
                                <ol>
                                    <li>Informações do Protocolo: <span
                                            class="text-danger"><strong>(Obrigatório)</strong></span>
                                        <ul>
                                            <li>"O seu protocolo de atendimento é <strong>[número do chamado gerado
                                                    ANATEL/ANEEL]</strong>.”</li>
                                        </ul>
                                    </li>
                                    <li>Encerramento:
                                        <ul>
                                            <li>"Há algo mais em que eu possa ajudar?"</li>
                                        </ul>
                                    </li>
                                    <li>Pesquisa de Satisfação:
                                        <ul>
                                            <li>"Você poderia participar da pesquisa de satisfação, gostaríamos muito de
                                                saber sua opinião sobre o nosso atendimento.”</li>
                                            <li>“Vou te encaminhar o para a pesquisa agora mesmo."</li>
                                        </ul>
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </li>
                </ol> --}}
                <div class="container container-custom treinamento">
                    @if (Auth::user()->group_id == 2 || Auth::user()->group_id == 1)
                        <div class="d-flex">
                            <!-- Botão para abrir o modal -->
                            <button type="button" class="ms-auto m-2 btn btn-dark" data-bs-toggle="modal" data-bs-target="#alterarArquivoModal">
                                Alterar Arquivo
                            </button>
                        </div>
                    @endif
                    
                    <iframe class="container h-100" src="{{ asset('storage/files/procedimentos.pdf') }}" type="application/pdf"></iframe>
                    
                    <!-- Modal para upload do novo arquivo -->
                    <div class="modal fade" id="alterarArquivoModal" tabindex="-1" aria-labelledby="alterarArquivoModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="alterarArquivoModalLabel">Alterar Arquivo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('procedures.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="arquivo" class="form-label">Escolha o novo arquivo PDF</label>
                                            <input class="form-control" type="file" id="arquivo" name="arquivo" accept="application/pdf" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Substituir</button>
                                    </form>
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

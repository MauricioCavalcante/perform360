@extends('layouts.main')

@section('title', 'Procedimentos')

@section('head')
    <link rel="stylesheet" href="/css/procedure.css">
@endsection

@section('content')
    <main class="container container-custom">
        <details class="p-2 mb-2">
            <summary><strong>Roteiro de ligações</strong></summary>
            <div class="container- container-custom">
                <ol>
                    <li>
                        Script de Atendimento
                        <ol>
                            <li>Saudação: <span class="text-danger"><strong>(Obrigatório)</strong></span>
                                <ul>
                                    <li>"Bom dia/Boa tarde/Boa noite, você ligou para Service Desk da <strong>#ANATEL/ANEEL#</strong> com
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
            </div>
            </ol>
        </details>
        <hr>
        <details class="p-2 mb-2">
            <summary><strong>Treinamentos</strong></summary>
        </details>
    </main>
@endsection

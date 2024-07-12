<?php

namespace App\Http\Controllers;

use App\Models\Questionario;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;


class QuestionarioController extends Controller
{
    // Exibe uma lista de todos as perguntas com os dados do cliente associado.
    public function index()
    {

        $questionarios = Questionario::with('cliente')->get();
        return view('questionarios.index', compact('questionarios'));
    }

    // Exibe o formulário para criar uma nova pergunta, com a lista de todos os clientes disponíveis.
    public function cadastrarPergunta()
    {
        $clientes = Cliente::all();
        return view('questionarios.create', compact('clientes'));
    }

    // Salva as perguntas no banco de dados.
    public function store(Request $request): RedirectResponse
{
    // Valida os dados recebidos da requisição.
    $request->validate([
        'pergunta' => 'required',
        'nota' => 'required|numeric|between:1,10', // Validação correta para aceitar números decimais
        'cliente_id' => 'required|array',
        'cliente_id.*' => 'exists:clientes,id', // Verifica se cada ID de cliente existe na tabela 'clientes'
    ]);

    try {
        // Converte o array de IDs em uma string separada por vírgula
        $clienteIds = implode(',', $request->cliente_id);

        // Cria uma nova pergunta com os dados validados.
        $perguntaData = Questionario::create([
            'pergunta' => $request->input('pergunta'),
            'nota' => floatval(str_replace(',', '.', $request->input('nota'))), // Converte ',' para '.' se necessário
            'cliente_id' => $clienteIds, // Define o ID do cliente
        ]);

        if (!$perguntaData) {
            throw new \Exception('Erro ao criar pergunta.');
        }

        // Redireciona para a lista de perguntas com uma mensagem de sucesso.
        return redirect()->route('user.painel_user')->with('success', 'Pergunta adicionada com sucesso');
    } catch (\Exception $e) {
        // Registra o erro no log e retorna para a página de criação com uma mensagem de erro
        Log::error('Erro ao criar pergunta: ' . $e->getMessage());
        return redirect()->route('user.painel_user ')->withErrors(['error' => 'Erro ao criar pergunta.']);
    }
}


    // Exibe o formulário para editar uma pergunta existente, com a lista de todos os clientes disponíveis.
    public function editarPergunta(Questionario $questionario)
    {
        $clientes = Cliente::all();
        return view('questionarios.create', compact('questionario', 'clientes'));
    }

    // Atualiza uma pergunta existente no banco de dados.
    public function updatePergunta(Request $request, Questionario $questionario)
    {
        // Valida os dados recebidos da requisição.
        $request->validate([
            'pergunta' => 'required',
            'nota' => 'required|float|between:1,10',
            'clientes_id' => 'nullable|exists:clientes,id',
        ]);

        // Atualiza a pergunta com os dados validados.
        $questionario->update($request->all());

        // Redireciona para a lista de perguntas com uma mensagem de sucesso.
        return redirect()->route('user.painel_user')->with('success', 'Pergunta atualizada com sucesso');
    }

    // Exclui uma pergunta do banco de dados.
    public function deletePergunta(Questionario $questionario)
    {
        $questionario->delete();

        // Redireciona para a lista de perguntas com uma mensagem de sucesso.
        return redirect()->route('user.painel_user')->with('success', 'Pergunta excluída com sucesso!');
    }
    public function details($id){

        $questionario = Questionario::find($id);

        $clienteIds = json_decode($questionario->cliente);


        $clientes = Cliente::all();
        $avaliacao = Questionario::where('id', $questionario->id)->get();

        return view('questionarios.questions_details', compact('clientes','questionario'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Questionario;
use App\Models\Cliente;
use Illuminate\Http\Request;

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
    public function salvarPergunta(Request $request)
    {
        // Valida os dados recebidos da requisição.
        $request->validate([
            'pergunta' => 'required',
            'nota' => 'required|integer|between:1,10',
            'clientes_id' => 'required|exists:clientes,id',
        ]);

        // Cria uma nova pergunta com os dados validados.
        Questionario::create($request->all());

        // Redireciona para a lista de perguntas com uma mensagem de sucesso.
        return redirect()->route('questionarios.index')->with('success', 'Pergunta adicionada com sucesso');
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
            'nota' => 'required|integer|between:1,10',
            'clientes_id' => 'required|exists:clientes,id',
        ]);

        // Atualiza a pergunta com os dados validados.
        $questionario->update($request->all());

        // Redireciona para a lista de perguntas com uma mensagem de sucesso.
        return redirect()->route('questionarios.index')->with('success', 'Pergunta atualizada com sucesso');
    }

    // Exclui uma pergunta do banco de dados.
    public function deletePergunta(Questionario $questionario)
    {
        $questionario->delete();

        // Redireciona para a lista de perguntas com uma mensagem de sucesso.
        return redirect()->route('questionarios.index')->with('success', 'Pergunta excluída com sucesso!');
    }
}

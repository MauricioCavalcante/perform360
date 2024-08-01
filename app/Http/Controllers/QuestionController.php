<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::all();
        $query = Question::query();

        $filterClientId = $request->get('client_id');
        if ($filterClientId) {

            $query->where('client_id', 'like', "%$filterClientId%");
        }

        $questions = $query->get();
        $totalScore = $query->sum('score');

        return view('questionnaires.panel', compact('questions', 'clients', 'totalScore', 'filterClientId'));
    }

    public function form(Question $question = null)
    {
        try {
            $clients = Client::all();
            return view('questionnaires.form', compact('question', 'clients'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar a página de edição: ' . $e->getMessage());
            return redirect()->route('questionnaires.panel')->with(['error' => 'Erro ao carregar a edição.']);
        }
    }

    public function editQuestion($id)
    {
        Log::info('Acessando a edição da pergunta: ' . $id);

        try {
            $question = Question::findOrFail($id);
            $clients = Client::all();
            return view('questionnaires.form', compact('question', 'clients', 'id'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar a página de edição: ' . $e->getMessage());
            return redirect()->route('questionnaires.index')->with(['error' => 'Erro ao carregar a edição.']);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'question' => ['required', 'string', 'max:65535'],
            'score' => ['required', 'numeric', 'between:1,100'],
            'client_id' => ['nullable', 'array'],
            'client_id.*' => ['exists:clients,id'],
        ]);

        $clientIds = $request->input('client_id', []);

        try {
            
            $questionData = Question::create([
                'question' => $request->input('question'),
                'score' => floatval(str_replace(',', '.', $request->input('score'))), // Converte ',' para '.' se necessário
                'client_id' => json_encode($clientIds), // Define o ID do cliente
                'version' => 1,
            ]);

            if (!$questionData) {
                Log::error('Erro ao criar pergunta.');
            }

            return redirect()->route('questionnaires.index')->with('success', 'Pergunta adicionada com sucesso');
        } catch (\Exception $e) {
           
            Log::error('Erro ao criar pergunta: ' . $e->getMessage());
            return redirect()->route('questionnaires.index')->withErrors(['error' => 'Erro ao criar pergunta.']);
        }
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'question' => ['required', 'string', 'max:65535'],
            'score' => ['required', 'numeric', 'between:1,100'],
            'client_id' => ['nullable', 'array'],
            'client_id.*' => ['exists:clients,id'],
        ]);

        try {
            $clientIds = $request->input('client_id', []);

            $question->question = $request->input('question');
            $question->score = floatval(str_replace(',', '.', $request->input('score')));
            $question->client_id = json_encode($clientIds);
            $question->version = $question->version + 1;
            $question->save();

            return redirect()->route('questionnaires.index')->with('success', 'Pergunta atualizada com sucesso');
        } catch (\Exception $e) {
        
            Log::error('Erro ao editar pergunta: ' . $e->getMessage());
            return redirect()->route('questionnaires.index')->withErrors(['error' => 'Erro ao editar pergunta.']);
        }
    }

    public function destroy($id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            return redirect()->route('questionnaires.index')->with('success', 'Pergunta excluída com sucesso.');
        } catch (\Exception $e) {
            
            Log::error('Erro ao excluir pergunta: ' . $e->getMessage());
            return redirect()->route('questionnaires.index')->withErrors(['error' => 'Erro ao excluir pergunta.']);
        }
    }
}

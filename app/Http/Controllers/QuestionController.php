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
            // Filtrar as questões onde o client_id está presente no JSON
            $query->whereJsonContains('client_id', $filterClientId);
        }
    
        // Obter todas as questões que correspondem ao filtro
        $questions = $query->get();
    
        // Inicializar um array para armazenar a soma do score por cliente
        $scoreByClient = [];
    
        foreach ($questions as $question) {
            // Decodificar o JSON do client_id para um array
            $clientsArray = json_decode($question->client_id);
    
            foreach ($clientsArray as $clientId) {
                // Verificar se já existe uma entrada para esse cliente no array
                if (!isset($scoreByClient[$clientId])) {
                    $scoreByClient[$clientId] = 0; // Inicializar a soma com 0
                }
    
                // Adicionar o score da questão ao cliente correspondente
                $scoreByClient[$clientId] += $question->score;
            }
        }
    
        // Converter o array em formato JSON
        $scoreByClientJson = json_encode($scoreByClient);
    
        return view('questionnaires.panel', compact('questions', 'clients', 'scoreByClientJson', 'filterClientId'));
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

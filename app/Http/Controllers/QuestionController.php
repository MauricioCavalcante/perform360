<?php

namespace App\Http\Controllers;

use App\Models\Question;

use App\Models\Client;
use App\Models\Evaluation;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::all();
        $query = Question::query();

        $query->where('deduction', 0);

        $filterClientId = $request->get('client_id');
        if ($filterClientId) {
            $query->where('client_id', 'like', "%$filterClientId%");
        }

        $questions = $query->get();
        $scoreByClient = [];

        foreach ($questions as $question) {
            $clientsArray = json_decode($question->client_id);

            foreach ($clientsArray as $clientId) {
                if (!isset($scoreByClient[$clientId])) {
                    $scoreByClient[$clientId] = 0;
                }

                $scoreByClient[$clientId] += $question->score;
            }
        }
        $scoreByClientJson = json_encode($scoreByClient);
        $deductions = Question::where('deduction', 1)->get();

        return view('questionnaires.panel', compact('questions', 'clients', 'scoreByClientJson', 'filterClientId', 'deductions'));
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
            'deduction' => ['nullable', 'in:Sim,Não'], // Valida que a dedução é opcional e pode ser 'Sim' ou 'Não'
            'client_id' => ['nullable', 'array'],
            'client_id.*' => ['exists:clients,id'],
        ]);

        $clientIds = $request->input('client_id', []);
        $deduction = $request->input('deduction', 'Não') === 'Sim' ? 1 : 0; // Define 'Não' como padrão

        try {
            $questionData = Question::create([
                'question' => $request->input('question'),
                'score' => floatval(str_replace(',', '.', $request->input('score'))), // Converte ',' para '.' se necessário
                'deduction' => $deduction, // Define o valor da dedução
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
        Log::info('Atualizando a pergunta com ID: ' . $id);

        try {
            $question = Question::findOrFail($id);

            $request->validate([
                'question' => ['required', 'string', 'max:65535'],
                'score' => ['required', 'numeric', 'between:1,100'],
                'deduction' => ['nullable', 'in:Sim,Não'],
                'client_id' => ['nullable', 'array'],
                'client_id.*' => ['exists:clients,id'],
            ]);

            $clientIds = $request->input('client_id', []);
            $deduction = $request->input('deduction', 'Não') === 'Sim' ? 1 : 0;

            $question->question = $request->input('question');
            $question->score = floatval(str_replace(',', '.', $request->input('score')));
            $question->client_id = json_encode($clientIds);
            $question->deduction = $deduction;
            $question->version += 1;
            $question->save();


            return redirect()->route('questionnaires.index')->with('success', 'Pergunta atualizada com sucesso');
        } catch (\Exception $e) {
            Log::error('Pergunta não encontrada para atualização: ' . $e->getMessage());
            return redirect()->route('questionnaires.index')->with('error', 'Pergunta não encontrada.');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar pergunta: ' . $e->getMessage());
            return redirect()->route('questionnaires.index')->withErrors(['error' => 'Erro ao atualizar pergunta.']);
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

    public function questionnaire($id)
    {

        $evaluation = Evaluation::findOrFail($id);
        $query = Question::query();
        $filterClientId = $evaluation->client_id;

        if ($filterClientId) {
            $query->where('client_id', 'like', "%$filterClientId%");
        }
        $questions = $query->get();

        $deductions = $questions->filter(function ($question) {
            return $question->deduction;
        });

        $nonDeductions = $questions->reject(function ($question) {
            return $question->deduction;
        });

        $questions = $deductions->merge($nonDeductions);
        $sumScore = $questions->sum('score');

        return view("evaluations.questionnaire", compact("id", "evaluation", "questions", "sumScore", "filterClientId"));
    }

    public function questionnaireSave(Request $request, $id)
    {
        // Depurar o array completo de perguntas
        Log::info('Perguntas recebidas:', $request->input('questions'));
    
        // Validar os dados recebidos
        $request->validate([
            'totalScore' => ['required', 'numeric'],
            'feedback' => ['nullable', 'string', 'max:255'],
            'questions' => ['required', 'array'],
            'questions.*.response' => ['required', 'numeric'],
            'questions.*.question' => ['required', 'string'],
            'questions.*.score' => ['required', 'numeric'],
            'questions.*.deduction' => ['nullable', 'numeric', 'in:0,1'], // Validar deduction como 0 ou 1
        ]);
    
        // Encontrar e atualizar a avaliação
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->score = $request->input('totalScore');
        $evaluation->feedback = $request->input('feedback');
        $evaluation->revision_requested = 0; // Ou ajuste conforme necessário
        $evaluation->save();
    
        // Determinar a nova versão
        $maxVersion = Questionnaire::where('evaluation_id', $evaluation->id)
            ->max('version');
        $newVersion = $maxVersion ? $maxVersion + 1 : 1;
    
        // Atualizar ou criar as perguntas
        foreach ($request->input('questions') as $questionId => $questionData) {
            $questionText = $questionData['question'];
            $response = $questionData['response'] == 0 ? 'Não' : 'Sim';
            $score = $questionData['score'];
            $deduction = (int) $questionData['deduction']; // Garantir que deduction é um inteiro
    
            // Adicionar log para verificar deduction
            Log::info('Salvando pergunta:', [
                'question_id' => $questionId,
                'question_text' => $questionText,
                'response' => $response,
                'score' => $score,
                'deduction' => $deduction,
            ]);
    
            // Verificar se a pergunta já existe na versão atual
            $existingQuestion = Questionnaire::where('evaluation_id', $evaluation->id)
                ->where('question', $questionText)
                ->where('version', $newVersion)
                ->first();
    
            if ($existingQuestion) {
                // Atualizar a pergunta existente
                $existingQuestion->response = $response;
                $existingQuestion->score = $score;
                $existingQuestion->deduction = $deduction;
                $existingQuestion->save();
            } else {
                // Criar uma nova pergunta
                Questionnaire::create([
                    'evaluation_id' => $evaluation->id,
                    'question' => $questionText,
                    'response' => $response,
                    'score' => $score,
                    'deduction' => $deduction,
                    'version' => $newVersion,
                ]);
            }
        }
    
        return redirect()->route('evaluations.details_evaluation', ['id' => $id])
            ->with('success', 'Avaliação salva com sucesso!');
    }
    
    
    public function questionnaireUpdate(Request $request, $id)
    {
       
        Log::info('Perguntas recebidas:', $request->input('questions'));
    
        
        $request->validate([
            'totalScore' => ['required', 'numeric'],
            'feedback' => ['nullable', 'string', 'max:255'],
            'questions' => ['required', 'array'],
            'questions.*.response' => ['required', 'numeric'],
            'questions.*.question' => ['required', 'string'],
            'questions.*.score' => ['required', 'numeric'],
            'questions.*.deduction' => ['nullable', 'numeric', 'in:0,1'], // Validar deduction como 0 ou 1
        ]);
    
       
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->score = $request->input('totalScore');
        $evaluation->feedback = $request->input('feedback');
        $evaluation->revision_requested = 0; // Ou ajuste conforme necessário
        $evaluation->save();
    
        // Determinar a nova versão
        $maxVersion = Questionnaire::where('evaluation_id', $evaluation->id)
            ->max('version');
        $newVersion = $maxVersion ? $maxVersion + 1 : 1;
    
        // Atualizar ou criar as perguntas
        foreach ($request->input('questions') as $questionId => $questionData) {
            $questionText = $questionData['question'];
            $response = $questionData['response'] == 0 ? 'Não' : 'Sim';
            $score = $questionData['score'];
            $deduction = (int) $questionData['deduction']; // Garantir que deduction é um inteiro
    
            // Adicionar log para verificar deduction
            Log::info('Salvando pergunta:', [
                'question_id' => $questionId,
                'question_text' => $questionText,
                'response' => $response,
                'score' => $score,
                'deduction' => $deduction,
            ]);
    
            // Verificar se a pergunta já existe na versão atual
            $existingQuestion = Questionnaire::where('evaluation_id', $evaluation->id)
                ->where('question', $questionText)
                ->where('version', $newVersion)
                ->first();
    
            if ($existingQuestion) {
                // Atualizar a pergunta existente
                $existingQuestion->response = $response;
                $existingQuestion->score = $score;
                $existingQuestion->deduction = $deduction;
                $existingQuestion->save();
            } else {
                // Criar uma nova pergunta
                Questionnaire::create([
                    'evaluation_id' => $evaluation->id,
                    'question' => $questionText,
                    'response' => $response,
                    'score' => $score,
                    'deduction' => $deduction,
                    'version' => $newVersion,
                ]);
            }
        }
    
        return redirect()->route('evaluations.details_evaluation', ['id' => $id])
            ->with('success', 'Avaliação atualizada com sucesso!');
    }
    
}
<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Job
use App\Jobs\TranscribeAudio;
use App\Models\Client;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\User;

class EvaluationController extends Controller
{
    public function index()
    {

        $client = Client::all();
        $avgScore = round(Evaluation::avg('score'), 1);
        $evaluation = Evaluation::orderBy("created_at", "desc")->paginate(15);
        $pagination = Evaluation::paginate(15);
        return view("evaluations.panel", compact("evaluation", "client", "avgScore", "pagination"));
    }
    public function create()
    {
        return view("evaluations.new_evaluation");
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'audio' => 'required|file|max:102400',
            ]);

            $file = $request->file('audio');
            $fileName = 'audio-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/upload', $fileName);

            $evaluation = new Evaluation();
            $evaluation->audio = $filePath;
            $evaluation->username = Auth::user()->name;
            $evaluation->save();

            TranscribeAudio::dispatch($evaluation->id, storage_path("app/{$evaluation->audio}"));

            return redirect()->route('evaluations.index')->with("warning", "O Áudio está sendo transcrito, por favor aguarde!");
        } catch (\Exception $e) {

            Log::error("Error processing the audio file: " . $e->getMessage());
            return redirect()->route('evaluations.index')->with("error", "Houve um problema ao transcrever o áudio.");
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'protocol' => ['nullable', 'string', 'max:255'],
            'client_id' => ['nullable', 'exists:clients,id'],  // Corrigido aqui
        ]);

        try {
            $evaluation = Evaluation::findOrFail($id);

            if (!$evaluation) {
                return redirect()->back()->with('error', 'Avaliação não encontrada.');
            }

            $evaluation->user_id = $request->input('user_id');
            $evaluation->protocol = $request->input('protocol');
            $evaluation->client_id = $request->input('client_id');
            $evaluation->save();

            return redirect()->route('evaluations.details_evaluation', $evaluation->id)->with('success', 'Avaliação atualizada!');
        } catch (\Exception $e) {

            Log::error("Erro ao atualizar a avaliação: " . $e->getMessage());
            return redirect()->back()->with('error', 'Houve um problema ao atualizar a avaliação.');
        }
    }

    public function questionnaire($id)
    {

        $evaluation = Evaluation::findOrFail($id);
        $sumScore = Question::sum('score');
        $query = Question::query();

        $filterClientId = $evaluation->client_id;

        if ($filterClientId) {
            $query->where('client_id', 'like', "%$filterClientId%");
        }

        $questions = $query->get();

        return view("evaluations.questionnaire", compact("id", "evaluation", "questions", "sumScore", "filterClientId"));
    }
    public function questionnaireSave(Request $request, $id)
    {
        $request->validate([
            'totalScore' => ['required', 'numeric'],
            'feedback' => ['nullable', 'string', 'max:255'],
            'questions' => ['required', 'array'],
            'questions.*.response' => ['required', 'numeric'],
            'questions.*.question' => ['required', 'string'],
            'questions.*.score' => ['required', 'numeric'],
            'serious_response' => ['required', 'numeric'],
            'serious_question' => ['required', 'string'],
            'serious_score' => ['required', 'numeric'],
        ]);
    
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->score = $request->input('totalScore');
        $evaluation->feedback = $request->input('feedback');
        $evaluation->save();
    
        // Verificar a maior versão existente para este evaluation_id
        $maxVersion = Questionnaire::where('evaluation_id', $evaluation->id)
            ->max('version');
    
        // Definir a nova versão
        $newVersion = $maxVersion ? $maxVersion + 1 : 1;
    
        // Salvar perguntas, respostas e notas na tabela questionnaires
        foreach ($request->input('questions') as $questionId => $questionData) {
            $response = $questionData['response'] == 0 ? 'Não' : 'Sim';
            Questionnaire::create([
                'evaluation_id' => $evaluation->id,
                'question' => $questionData['question'],
                'response' => $response,
                'score' => $questionData['score'],
                'version' => $newVersion, // Adiciona a nova versão
            ]);
        }
    
        // Salvar a questão séria
        $seriousResponse = $request->input('serious_response') == 0 ? 'Sim' : 'Não';
        Questionnaire::create([
            'evaluation_id' => $evaluation->id,
            'question' => $request->input('serious_question'),
            'response' => $seriousResponse,
            'score' => $request->input('serious_score'),
            'version' => $newVersion, // Adiciona a nova versão
        ]);
    
        return redirect()->route('evaluations.details_evaluation', ['id' => $id])
            ->with('success', 'Avaliação salva com sucesso!');
    }
    
    


    public function destroy($id)
    {
        try {

            $evaluation = Evaluation::findOrFail($id);
            $evaluation->delete();

            return redirect()->route('evaluations.index')->with('success', 'Avaliação excluída com sucesso.');
        } catch (\Exception $e) {

            Log::error("Erro ao excluir a avaliação: " . $e->getMessage());
            return redirect()->route('evaluations.index')->with('error', 'Houve um problema ao excluir a avaliação.');
        }
    }

    public function details($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $user = User::all();
        $client = Client::all();

        return view('evaluations.details_evaluation', compact('id', 'user', 'client', 'evaluation'));
    }
    public function showEvaluationDetails($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $questionnaires = Questionnaire::where('evaluation_id', $evaluation->id)
        ->where('version', function ($query) use ($evaluation) {
            $query->selectRaw('MAX(version)')
                ->from('questionnaires')
                ->where('evaluation_id', $evaluation->id);
        })
        ->get();

        return view('evaluations.details_questionnaire', compact('evaluation', 'questionnaires'));
    }
}

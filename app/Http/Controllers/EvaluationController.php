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
            // Validate the audio file
            $request->validate([
                'audio' => 'required|file|max:102400',
            ]);

            // Process the audio file upload
            $file = $request->file('audio');
            $fileName = 'audio-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/upload', $fileName);

            // Create a new Evaluation instance and save the file path
            $evaluation = new Evaluation();
            $evaluation->audio = $filePath;
            $evaluation->username = Auth::user()->name; // Changed from 'usuario'
            $evaluation->save();

            // Dispatch the job to transcribe the audio in the background
            TranscribeAudio::dispatch($evaluation->id, storage_path("app/{$evaluation->audio}"));

            // Return a response to the user
            return redirect()->route('evaluations.index')->with("warning", "O Áudio está sendo transcrito, por favor aguarde!");
        } catch (\Exception $e) {
            // Log the error
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

            // Verificar se a avaliação foi encontrada
            if (!$evaluation) {
                return redirect()->back()->with('error', 'Avaliação não encontrada.');
            }

            // Atualizar os campos com os novos valores do formulário
            $evaluation->user_id = $request->input('user_id');
            $evaluation->protocol = $request->input('protocol');
            $evaluation->client_id = $request->input('client_id'); // Assumindo que o campo no modelo é 'cliente_id'
            $evaluation->save();

            // Redirecionar de volta para a página da avaliação com uma mensagem de sucesso
            return redirect()->route('evaluations.details_evaluation', $evaluation->id)->with('success', 'Avaliação atualizada!');
        } catch (\Exception $e) {
            // Registrar o erro, se houver
            Log::error("Erro ao atualizar a avaliação: " . $e->getMessage());
            return redirect()->back()->with('error', 'Houve um problema ao atualizar a avaliação.');
        }
    }

    public function questionnaire($id)
    {

        $evaluation = Evaluation::findOrFail($id);
        $questions = Question::all();
        $sumScore = Question::sum('score');

        $query = Question::query();


        // Verifica se há filtro por cliente aplicado
        $filterClientId = $evaluation->client_id;
        if ($filterClientId) {
            // Filtrar os questionários pelo cliente selecionado
            $query->where('client_id', 'like', "%$filterClientId%");
        }


        // Busca as perguntas conforme o filtro aplicado
        $questions = $query->get();

        return view("evaluations.questionnaire", compact("id", "evaluation", "questions", "sumScore", "questions", 'filterClientId'));
    }

    public function questionnaireSave(Request $request, $id)
    {
        // Validação dos dados recebidos do formulário
        $request->validate([
            'totalScore' => ['required', 'numeric'],
            'feedback' => ['nullable', 'string', 'max:255'],
        ]);

        // Atualiza a avaliação com os dados recebidos
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->score = $request->input('totalScore');
        $evaluation->feedback = $request->input('feedback');
        $evaluation->save();

        
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
}

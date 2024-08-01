<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Obtenha todos os clientes e mapeie por ID para acesso rápido
        $clients = Client::all()->keyBy('id');
        
        // Obtenha os dados dos usuários (classificação)
        $users = User::where('group_id', 4)->get();

        $evaluations = Evaluation::all();

        // Contagem de avaliações por usuário (classificação)
        $countEvaluationUser = Evaluation::select('user_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->get();
        
        // Média de pontuação por usuário (classificação)
        $averageScores = Evaluation::select('user_id', DB::raw('AVG(score) as average_score'))
            ->groupBy('user_id')
            ->get();
        
        // Contagem de avaliações com pontuação (Card)
        $countEvaluation = Evaluation::whereNotNull('score')->count();
        // Média geral das avaliações (Card)
        $score = Evaluation::average('score');

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyAverageScore = Evaluation::whereBetween('updated_at', [$startOfMonth, $endOfMonth])
            ->whereNotNull('score')
            ->average('score');


        // Total de avaliações (Card)
        $totalEvaluation = Evaluation::count();

        // Contagem de avaliações por cliente (gráfico)
        $countEvaluationClient = Evaluation::select('client_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('client_id')
            ->groupBy('client_id')
            ->get();

        // Preparar dados para o gráfico de clientes
        $points = $countEvaluationClient->map(function ($item) use ($clients) {
            $clientName = $clients->has($item->client_id) ? $clients[$item->client_id]->name : 'Unknown';
            return [
                'name' => $clientName,
                'y' => $item->total
            ];
        });

        // Calcular a média mensal das pontuações
        $monthlyAverages = Evaluation::select(DB::raw('DATE_FORMAT(updated_at, "%Y-%m") as month'), DB::raw('AVG(score) as average_score'))
            ->whereNotNull('score')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Preparar dados para o gráfico de médias gerais
        $generalAverageData = $monthlyAverages->map(function ($item) {
            return [
                'name' => $item->month,
                'y' => $item->average_score
            ];
        });

        // Calcular a média mensal das pontuações por cliente
        $clientMonthlyAverages = Evaluation::select(
            'client_id',
            DB::raw('DATE_FORMAT(updated_at, "%Y-%m") as month'),
            DB::raw('AVG(score) as average_score')
        )
        ->whereNotNull('score')
        ->groupBy('client_id', 'month')
        ->orderBy('client_id')
        ->orderBy('month')
        ->get();

        // Agrupando os dados por cliente
        $clientAverageData = $clientMonthlyAverages->groupBy('client_id')->map(function ($items, $clientId) use ($clients) {
            $clientName = $clients->has($clientId) ? $clients[$clientId]->name : "Client $clientId";
            return [
                'name' => $clientName,
                'data' => $items->map(function ($item) {
                    return [
                        'name' => $item->month,
                        'y' => $item->average_score
                    ];
                })->values()->toArray()
            ];
        });

        // Passar os dados para a view
        return view('index', [
            'users' => $users,
            'clients' => $clients,
            'evaluations' => $evaluations,
            'monthlyAverageScore' => $monthlyAverageScore,
            'totalEvaluation' => $totalEvaluation,
            'countEvaluation' => $countEvaluation,
            'countEvaluationUser' => $countEvaluationUser,
            'averageScores' => $averageScores,
            'data' => $points, // Dados para o gráfico de clientes
            'generalAverageData' => $generalAverageData->toJson(), // Dados para o gráfico de médias gerais
            'clientAverageData' => $clientAverageData->values()->toJson() // Dados para o gráfico de médias por cliente
        ]);
    }
}

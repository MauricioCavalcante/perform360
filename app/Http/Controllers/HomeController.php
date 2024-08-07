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
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $clients = Client::all()->keyBy('id');

        $users = User::where('group_id', 4)->get();

        $evaluations = Evaluation::all();
        $totalEvaluation = Evaluation::count();
        $countEvaluation = Evaluation::whereNotNull('score')->count();

        $evaluationCountUser = Evaluation::select('user_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('user_id')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('user_id')
            ->get();

        $averageScores = Evaluation::select('user_id', DB::raw('AVG(score) as average_score'))
            ->groupBy('user_id')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();


        $monthlyAverageScore = Evaluation::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereNotNull('score')
            ->average('score');
        $monthlyAverageScore = number_format($monthlyAverageScore, 2, '.', '');
        
        $countEvaluationClient = Evaluation::select('client_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('client_id')
            ->groupBy('client_id')
            ->get();

        $points = $countEvaluationClient->map(function ($item) use ($clients) {
            $clientName = $clients->has($item->client_id) ? $clients[$item->client_id]->name : 'Unknown';
            return [
                'name' => $clientName,
                'y' => $item->total
            ];
        });

        $monthlyAverages = Evaluation::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('AVG(score) as average_score'))
            ->whereNotNull('score')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $generalAverageData = $monthlyAverages->map(function ($item) {
            return [
                'name' => $item->month,
                'y' => $item->average_score
            ];
        });

        $clientMonthlyAverages = Evaluation::select('client_id', DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('AVG(score) as average_score'))
            ->whereNotNull('score')
            ->groupBy('client_id', 'month')
            ->orderBy('client_id')
            ->orderBy('month')
            ->get();

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

        return view('index', [
            'users' => $users,
            'clients' => $clients,
            'evaluations' => $evaluations,
            'monthlyAverageScore' => $monthlyAverageScore,
            'totalEvaluation' => $totalEvaluation,
            'countEvaluation' => $countEvaluation,
            'evaluationCountUser' => $evaluationCountUser,
            'averageScores' => $averageScores,
            'data' => $points,
            'generalAverageData' => $generalAverageData->toJson(),
            'clientAverageData' => $clientAverageData->values()->toJson()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Client;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $client = Client::all();
        $namesClients = $client->pluck('name')->implode(', ');
        $evaluation = Evaluation::all();
        $countEvaluation = Evaluation::whereNotNull('score')->count();

        $score = Evaluation::average('score'); 

        $totalEvaluation = Evaluation::count();

        return view("index" , compact("client","evaluation", "score", "totalEvaluation", "countEvaluation", "namesClients"));
    }
    public function getBarChartData(Request $request)
    {
        // Obtemos a média mensal das avaliações
        $mediaMensalNotas = Evaluation::selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, AVG(avaliacao) as media_avaliacao')
            ->groupBy('ano', 'mes')
            ->orderBy('ano', 'asc')
            ->orderBy('mes', 'asc')
            ->get();

        // Criar arrays para os labels e os dados da média mensal das avaliações
        $labels = $mediaMensalNotas->map(function ($item) {
            return $item->ano . '-' . str_pad($item->mes, 2, '0', STR_PAD_LEFT); // Formato: YYYY-MM
        })->toArray();
        $mediaNotas = $mediaMensalNotas->map(function ($item) {
            return $item->media_avaliacao;
        })->toArray();

        // Obtemos o total mensal de chamados por cliente
        $totalMensalChamados = Evaluation::selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, id_client, COUNT(*) as total_chamados')
            ->groupBy('ano', 'mes', 'id_client')
            ->orderBy('ano', 'asc')
            ->orderBy('mes', 'asc')
            ->get();

        // Criar arrays para os labels e os dados do total mensal de chamados
        $totalChamadosLabels = $totalMensalChamados->map(function ($item) {
            $cliente = Client::find($item->id_client);
            $clienteNome = $cliente ? $cliente->name : 'Cliente sem nome';
            return $item->ano . '-' . str_pad($item->mes, 2, '0', STR_PAD_LEFT) . ' - ' . $clienteNome; // Formato: YYYY-MM - Nome do Cliente
        })->toArray();
        $totalChamadosData = $totalMensalChamados->map(function ($item) {
            return $item->total_chamados;
        })->toArray();

        // Passamos os dados para a view
        return view('index', [
            'mediaNotas' => $mediaNotas,
            'labels' => $labels,
            'totalChamadosLabels' => $totalChamadosLabels,
            'totalChamadosData' => $totalChamadosData,
        ]);
    }
}

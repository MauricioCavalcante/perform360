<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Avaliacoe;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use App\Jobs\TranscreverAudio;


class AvaliacaoController extends Controller
{
    public function create()
    {
        return view("avaliacoes.nova_avaliacao");
    }
    public function read()
    {

        $avaliacoes = Avaliacoe::all();


        return view('avaliacoes.painel', ['avaliacoes' => $avaliacoes]);
    }

    public function store(Request $request)
    {
        // Validação do arquivo de áudio
        $request->validate([
            'audio' => 'required|mimes:wav,mp3|max:10240', // max size 10MB e tipos permitidos
        ]);

        // Salvar o arquivo de áudio
        $file = $request->file('audio');
        $fileName = 'chamado-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/upload', $fileName);

        // Criar um novo registro de Avaliacoe
        $avaliacao = new Avaliacoe();
        $avaliacao->audio = $filePath;
        $avaliacao->save();

        // Despachar a tarefa para a fila
        TranscreverAudio::dispatch($avaliacao->id, storage_path('app/' . $filePath));

        // Redirecionar para a view com a mensagem de que o áudio está sendo transcrito
        return redirect()->route('avaliacoes.painel')->with('success', 'Áudio está sendo transcrito, aguarde!');
    }

    public function details($id){

        $avaliacao = Avaliacoe::findOrFail($id);

        return view('avaliacoes.details_avaliacao', ['id' => $id, 'avaliacao' => $avaliacao]);
    }
}

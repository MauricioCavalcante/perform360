<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Avaliacao;
use App\Models\User;
use App\Models\Cliente;
use App\Jobs\TranscreverAudio;

class AvaliacaoController extends Controller
{
    public function create()
    {
        return view("avaliacoes.nova_avaliacao");
    }

    public function read()
    {
        $avaliacoes = Avaliacao::orderBy('created_at', 'desc')->get();
        return view('avaliacoes.painel', ['avaliacoes' => $avaliacoes]);
    }

    public function store(Request $request)
    {
        try {
            // Validação do arquivo de áudio
            $request->validate([
                'audio' => 'required|file',
            ]);

            // Processa o upload do arquivo de áudio
            $file = $request->file('audio');
            $fileName = 'audio-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/upload', $fileName);

            // Cria uma nova instância de Avaliacoe e salva o caminho do arquivo
            $avaliacao = new Avaliacao();
            $avaliacao->audio = $filePath;
            $avaliacao->save();

            // Enfileira o job para transcrever o áudio em segundo plano
            TranscreverAudio::dispatch($avaliacao->id, storage_path("app/{$avaliacao->audio}"));

            // Retorna uma resposta para o usuário
            return redirect('/avaliacoes/painel')->with("warning", "Áudio está sendo transcrito, aguarde!");
        } catch (\Exception $e) {
            // Registra o erro
            Log::error("Erro ao processar o arquivo de áudio: " . $e->getMessage());
            return redirect('/avaliacoes/painel')->with("error", "Houve um problema ao processar o arquivo de áudio.");
        }
    }


    public function details($id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        $users = User::all();
        $clientes = Cliente::all();
        return view('avaliacoes.details_avaliacao', [
            'id' => $id,
            'avaliacao' => $avaliacao,
            'users' => $users,
            'clientes' => $clientes, // Adicione os clientes ao array associativo
        ]);
    }

    public function destroy($id)
    {
        try {
            $avaliacao = Avaliacao::findOrFail($id);
            $avaliacao->delete();
            return redirect()->route('avaliacoes.painel')->with('success', 'Avaliação excluída com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir a avaliação: " . $e->getMessage());
            return redirect()->route('avaliacoes.painel')->with('error', 'Houve um problema ao excluir a avaliação.');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => ['nullable', 'exists:users,id'],
            'num_chamado' => ['nullable', 'string', 'max:255'],
            'titulo' => ['required', 'string', 'max:255'],
            'cliente_id' => ['nullable', 'exists:clientes,id'],  // Corrigido aqui
        ]);

        try {
            $avaliacao = Avaliacao::findOrFail($id);

            // Verificar se a avaliação foi encontrada
            if (!$avaliacao) {
                return redirect()->back()->with('error', 'Avaliação não encontrada.');
            }

            // Atualizar os campos com os novos valores do formulário
            $avaliacao->id_user = $request->input('id_user');
            $avaliacao->num_chamado = $request->input('num_chamado');
            $avaliacao->id_cliente = $request->input('cliente_id'); // Assumindo que o campo no modelo é 'cliente_id'
            $avaliacao->titulo = $request->input('titulo');
            $avaliacao->save();

            // Redirecionar de volta para a página da avaliação com uma mensagem de sucesso
            return redirect()->route('avaliacoes.details_avaliacao', $avaliacao->id)->with('success', 'Avaliação atualizada!');
        } catch (\Exception $e) {
            // Registrar o erro, se houver
            Log::error("Erro ao atualizar a avaliação: " . $e->getMessage());
            return redirect()->back()->with('error', 'Houve um problema ao atualizar a avaliação.');
        }
    }
}

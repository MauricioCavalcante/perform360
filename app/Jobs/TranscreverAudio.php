<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Avaliacao;
use App\Models\Notification;

class TranscreverAudio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $avaliacaoId;
    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param int $avaliacaoId
     * @param string $filePath
     * @return void
     */
    public function __construct($avaliacaoId, $filePath)
    {
        $this->avaliacaoId = $avaliacaoId;
        $this->filePath = $filePath;

        Log::info("Job de transcrição de áudio iniciado para avaliação ID: " . $this->avaliacaoId);
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Iniciando job para transcrever áudio para avaliação ID: " . $this->avaliacaoId);
        Log::info("Caminho do arquivo de áudio: " . $this->filePath);

        $pythonExecutable = base_path('venv\\Scripts\\python.exe');
        $pythonScriptPath = base_path('app\\scripts\\transcrever_audio.py');

        $command = escapeshellcmd("$pythonExecutable $pythonScriptPath " . escapeshellarg($this->filePath));
        Log::info("Comando a ser executado: $command");

        // Executa o comando e captura a saída
        $output = shell_exec($command);

        if (empty($output)) {
            Log::error("A saída do script Python está vazia. Comando: $command");
            return;
        }

        Log::info("Saída bruta do script Python: " . $output);

        try {
            // Convertendo a saída para UTF-8
            $output = mb_convert_encoding($output, 'UTF-8', 'auto');
            Log::info('Transcrição recebida após mb_convert_encoding: ' . $output);
        } catch (\Exception $e) {
            Log::error("Erro ao converter a saída para UTF-8: " . $e->getMessage());
            return;
        }

        try {
            $avaliacao = Avaliacao::findOrFail($this->avaliacaoId);
            $avaliacao->transcricao = $output;
            $avaliacao->save();
            Log::info("Avaliação ID: " . $this->avaliacaoId . " atualizada com sucesso.");
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar a avaliação: " . $e->getMessage());
        }

        Log::info("Job concluído para avaliação ID: " . $this->avaliacaoId);

        try {
            $notification = new Notification();
            $notification->notification = "Transcrição da avaliação " . $this->avaliacaoId . " concluída!";
            $notification->avaliacao_id  = $this->avaliacaoId;
            $notification->save();
            Log::info("Notificação criada para avaliação ID: " . $this->avaliacaoId);
        } catch (\Exception $e) {
            Log::error("Erro ao criar notificação: " . $e->getMessage());
        }
    }
}

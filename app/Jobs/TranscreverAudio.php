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
        ini_set('default_charset', 'UTF-8');

        Log::info("Iniciando job para transcrever áudio para avaliação ID: " . $this->avaliacaoId);
        Log::info("Iniciando job para transcrever áudio para avaliação Path: " . $this->filePath);

        // Caminho do executável do Python dentro do ambiente virtual
        $pythonExecutable = base_path('venv') . '/bin/python3';
        // Caminho completo para o script Python
        $pythonScriptPath = base_path('app') . '/Scripts/transcrever_audio.py';

        // Comando para execução do script Python
        $command = "$pythonExecutable $pythonScriptPath " . escapeshellarg($this->filePath);
        $output = shell_exec($command);

        if ($output === null) {
            Log::error("Erro ao executar o comando: $command");
        } else if (trim($output) === "") {
            Log::error("A saída do script Python está vazia. Comando: $command");
        } else {
            Log::info("Saída bruta do script Python: " . $output);

            try {
                // Garantindo que a saída está em UTF-8
                $output = mb_convert_encoding($output, 'UTF-8', 'auto');
                Log::info('Transcrição recebida após mb_convert_encoding: ' . $output);
            } catch (\Exception $e) {
                Log::error("Erro ao converter a saída para UTF-8: " . $e->getMessage());
                Log::error("Saída do script Python: " . $output);
                return;
            }

            try {
                $avaliacao = Avaliacao::findOrFail($this->avaliacaoId);
                $avaliacao->transcricao = $output;
                $avaliacao->save();
                Log::info("Avaliação ID: " . $this->avaliacaoId . " atualizada com sucesso.");
            } catch (\Exception $e) {
                Log::error("Erro ao atualizar a avaliação: " . $e->getMessage());
                return;
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
}

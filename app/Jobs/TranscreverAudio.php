<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Avaliacoe;
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Caminho completo para o script Python de transcrição de áudio
        $pythonScriptPath = base_path('app/scripts/transcrever_audio.py');

        // Executar o script Python para transcrever o áudio
        $command = "python3 $pythonScriptPath $this->filePath";
        $output = shell_exec($command);

        // Registre a saída do script Python no arquivo de log do Laravel
        Log::info("Saída do script Python: $output");

        // Atualizar a avaliação com a transcrição obtida
        $avaliacao = Avaliacoe::findOrFail($this->avaliacaoId);
        $avaliacao->transcricao = $output;
        $avaliacao->save();

        // Criar uma nova notificação para o usuário
        $notification = new Notification();
        $notification->notification = 'Nova avaliação disponível!';
        $notification->save();
    }
}

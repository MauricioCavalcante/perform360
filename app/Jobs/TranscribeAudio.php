<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Evaluation;
use App\Models\Notification;

class TranscribeAudio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $evaluationId;
    protected $filePath;

    public function __construct($evaluationId, $filePath)
    {
        $this->evaluationId = $evaluationId;
        $this->filePath = $filePath;

        Log::info("Audio transcription job started for evaluation ID: " . $this->evaluationId);
    }

    public function handle()
    {
        ini_set('default_charset', 'UTF-8');

        Log::info("Starting job to transcribe audio for evaluation ID: " . $this->evaluationId);
        Log::info("Audio file path: " . $this->filePath);

        $pythonExecutable = base_path('venv\\Scripts\\python.exe');
        $pythonScriptPath = base_path('app\\Scripts\\transcribe_audio.py');

        $command = escapeshellcmd("$pythonExecutable $pythonScriptPath " . escapeshellarg($this->filePath));
        $output = shell_exec($command);

        if ($output === null) {
            Log::error("Error executing the command: $command");
        } else if (trim($output) === "") {
            Log::error("The output from the Python script is empty. Command: $command");
        } else {
            Log::info("Raw output from the Python script: " . $output);

            try {
                $output = mb_convert_encoding($output, 'UTF-8', 'auto');

                Log::info('Transcription received after mb_convert_encoding: ' . $output);
            } catch (\Exception $e) {
                Log::error("Error converting the output to UTF-8: " . $e->getMessage());
                Log::error("Python script output: " . $output);
                return;
            }

            try {
                $evaluation = Evaluation::findOrFail($this->evaluationId);
                $evaluation->transcription = $output;
                $evaluation->save();
                Log::info("Evaluation ID: " . $this->evaluationId . " updated successfully.");
            } catch (\Exception $e) {
                Log::error("Error updating the evaluation: " . $e->getMessage());
                return;
            }

            Log::info("Job completed for evaluation ID: " . $this->evaluationId);

            try {
                $notification = new Notification();
                $notification->notification = "Transcrição da avaliação " . $this->evaluationId . " finalizada!";
                $notification->evaluation_id = $this->evaluationId;
                $notification->save();
                Log::info("Notification created for evaluation ID: " . $this->evaluationId);

                // Return a signal to the frontend
                echo '<script>window.onload = function() { document.getElementById("notificationBubble").style.display = "block"; }</script>';
            } catch (\Exception $e) {
                Log::error("Error creating notification: " . $e->getMessage());
            }
        }
    }
}

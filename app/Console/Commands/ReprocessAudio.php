<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evaluation;
use App\Jobs\TranscribeAudio;

class ReprocessAudio extends Command
{
    protected $signature = 'audio:reprocess {ids*}';
    protected $description = 'Reprocess audio files by their evaluation IDs';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $ids = $this->argument('ids');

        foreach ($ids as $id) {
            $evaluation = Evaluation::find($id);

            if ($evaluation) {
                TranscribeAudio::dispatch($evaluation->id, storage_path("app/{$evaluation->audio}"));
                $this->info("Reprocessing audio for evaluation ID: {$id}");
            } else {
                $this->error("No evaluation found for ID: {$id}");
            }
        }
    }
}

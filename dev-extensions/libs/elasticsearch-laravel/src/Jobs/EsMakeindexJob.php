<?php

namespace Dev\ElasticsearchLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

use Throwable;

class EsMakeindexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entities;
    protected $logger = 'elastic-makeindex';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($entities)
    {
        try {
            $this->entities = $entities;

            $this->logger = apps_logger($this->logger);
        } catch (Throwable $th) {
            Log::channel($this->logger)->error($th->getMessage());
            Log::channel($this->logger)->error($th->getTraceAsString());
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            app('es-makeindex')->initialize()->bulk($this->entities);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            Log::error($th->getTraceAsString());
        }
    }
}

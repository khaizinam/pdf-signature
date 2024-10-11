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

class EsMakeindexSingleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entity;
    protected $logger = 'elastic-makeindex';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($entity)
    {
        try {
            $this->entity = $entity;

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
            app('es-makeindex')->initialize()->setEntity($this->entity)->setBody()->execute();
        } catch (Throwable $th) {
            Log::channel($this->logger)->error($th->getMessage());
            Log::channel($this->logger)->error($th->getTraceAsString());
        }
    }
}

<?php

namespace Dev\ElasticsearchLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

use Basemkhirat\Elasticsearch\Facades\ES;

use DateTime;
use Exception;
use Throwable;

use Dev\ElasticsearchLaravel\Jobs\EsMakeindexJob;
use Dev\ElasticsearchLaravel\Jobs\EsMakeindexSingleJob;

class ElasticSearchMakeIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:makeindex {index?}{--limit=100} {--offset=0} {--action=index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elastic Search make index';
    protected $logger = 'elastic-makeindex';
    protected $indexName;

    /**
     * ES object
     * @var object
     */
    protected $es;
    protected $client;

    public function __construct()
    {
        $this->es = app("es");
        $this->logger = apps_logger($this->logger);

        parent::__construct();
    }

    /**
     * Ex: APPLICATION_ENV=development && php -d memory_limit=-1 artisan es:makeindex
     *
     * --action : index|update
     * --limit : total records will be indexed per runtime
     * --offset: Đánh `index` từ `mysql records` thứ `N = offset`
     *
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     */
    public function handle(): mixed
    {
        #region create index
        $this->client = $this->es->connection(config("es.default"))->raw();
        if (!$this->client->ping()) {
            $this->output->writeln(
                sprintf(
                    '<info>Please check your connection</info>'
                )
            );
            return self::FAILURE;
        }
        $indices = !is_null($this->argument('index')) ?
            [$this->argument('index')] :
            array_keys(config('es.indices'));

        foreach ($indices as $index) {
            if ($this->client->indices()->exists(['index' => $index])) {
                $this->warn("Index {$index} is already exists!");
            } else {
                try {
                    $config = config("es.indices.{$index}");
                    if (is_null($config)) {
                        $this->warn("Missing configuration for index: {$index}");
                        return self::FAILURE;
                    }
                    if (!$this->argumentIsValid($index)) {
                        return self::FAILURE;
                    }

                    $this->client->indices()->create([
                        'index' => $index,
                        'body' => [
                            "settings" => $config['settings']
                        ]
                    ]);
                    if (isset($config['aliases'])) {
                        foreach ($config['aliases'] as $alias) {
                            $this->info("Creating alias: {$alias} for index: {$index}");
                            $this->client->indices()->updateAliases([
                                "body" => [
                                    'actions' => [
                                        [
                                            'add' => [
                                                'index' => $index,
                                                'alias' => $alias
                                            ]
                                        ]
                                    ]
                                ]
                            ]);
                        }
                    }
                    if (isset($config['mappings'])) {
                        foreach ($config['mappings'] as $type => $mapping) {
                            // Create mapping for type from config file
                            $this->info("Creating mapping for type: {$type} in index: {$index}");
                            $this->client->indices()->putMapping([
                                'index' => $index,
                                'type' => $type,
                                'body' => $mapping
                            ]);
                        }
                    }
                } catch (Throwable $exception) {
                    $this->output->writeln(
                        sprintf(
                            '<error>Error creating index %s, exception message: %s.</error>',
                            $index,
                            $exception->getMessage()
                        )
                    );

                    return self::FAILURE;
                }
                $this->output->writeln(
                    sprintf(
                        '<info>Index %s created.</info>',
                        $index
                    )
                );
            }
        }
        #endregion create index

        #region indexing data
        try {
            $this->info('====================================================================================');
            Log::channel($this->logger)->info('====================================================================================');

            $models = [];
            foreach ($indices as $index) {
                foreach (config("es.indices.{$index}.makeindex.models") as $key => $model) {
                    $models[$key] = $model;
                }
            }

            $action = $this->option('action');
            $chunkSize = $limit = $this->option('limit'); // total records will be indexed per runtime

            // BEGIN CHECKING STATISTIC OF ELASTICSEARCH & MYSQL
            $lastLogs = $choices = [];
            foreach ($models as $entityClass => $property) {
                $collection = Str::of($entityClass)->explode("\\");

                if ($collection instanceof Collection) {
                    $entityName = $collection->last(); // Member
                } else {
                    $this->output->writeln(
                        sprintf(
                            '<info>Please check your entity</info>'
                        )
                    );
                    return self::FAILURE;
                }
                $entityNamespace = $collection->slice(0, -1)->implode('\\'); // $this->argument('namespace');
                $choices[] = $entityClass;

                $indexName = strtolower(Str::slug(env('APP_NAME', 'pkhl'), '_') . "_{$entityName}");
                $lastLogs[$entityName]['indexed'] =  ES::index($indexName)->count() - 1;
                $lastLogs[$entityName]['total'] = $entityClass::count();

                $this->info($entityName . ' (Indexed / Rows): ' . $lastLogs[$entityName]['indexed'] . ' / ' . $lastLogs[$entityName]['total']);
            } // end foreach

            // Asking you
            if ($this->confirm('Do you wish to continue?', true)) {
                $choice = $this->choice('What is your name?', $choices);
            } else {
                dd('Bye!');
            }
            $entityClass = "{$choice}"; // important! must be overide which choosen entity
            $this->info("================ {$entityClass}");

            $collection = Str::of($choice)->explode("\\");
            if ($collection instanceof Collection) {
                $entityName = $collection->last(); // Member
            }

            // END CHECKING STATISTIC OF ELASTICSEARCH & MYSQL
            // BEGIN MAKE INDEX FOR ELASTICSEARCH
            $offset = $this->option('offset') > 0 ? $this->option('offset') : $lastLogs[$entityName]['indexed'];
            if ($action == 'update') {
                $offset = 0;
            }

            // Get total records from Mysql
            $totalRecords = $lastLogs[$entityName]['total']; // tổng số records trong mysql
            $totalRecordsIndexed = $lastLogs[$entityName]['indexed']; // tổng số records đã được indexed vào elasticsearh
            $totalRemainingRecords = ceil(round($totalRecords - $totalRecordsIndexed)); // tổng số records còn lại cần được đánh index

            $totalPages = ceil(round($totalRecords / $limit)); // tổng số pages trong mysql
            $totalRemainingPages = ceil(round(($totalRecords - $offset)) / $limit); // tổng số pages còn lại cần được đánh index
            $totalPagesIndexed = ceil(round($totalRecordsIndexed / $limit)); // tổng số pages đã đánh index

            $currentPage = ceil(round($offset / $limit));
            $nextPage = ceil(round($offset / $limit)) + 1;

            $this->info("Starting with page: {$nextPage}, last indexed page: {$currentPage}");
            $this->info("Total Indexed records / Total mysql records: {$totalRecordsIndexed} / {$totalRecords}");
            $this->info("Total Indexed pages / Total mysql pages: {$totalPagesIndexed} / {$totalPages}");
            $this->info("Remaining pages need to be indexing: {$totalRemainingPages}");

            Log::channel($this->logger)->info("Starting with page: {$nextPage}, last indexed page: {$currentPage}");
            Log::channel($this->logger)->info("Total Indexed records / Total mysql records: {$totalRecordsIndexed} / {$totalRecords}");
            Log::channel($this->logger)->info("Remaining pages need to be indexing: {$totalRemainingPages}");

            $this->output->progressStart($totalRemainingPages);

            if ($action == 'index' or $action == 'update') {
                for ($p = ($nextPage - 1); $p <= $totalPages; $p++) :
                    $offset = ($p - 1) * $limit; // đánh lùi lại 1 page để đảm bảo không sót
                    // ...........
                    $this->info("\nIndexing PAGE: $p, with current OFFSET: $offset, LIMIT: $limit");
                    Log::channel($this->logger)->info("Indexing PAGE: $p, with current OFFSET: $offset, LIMIT: $limit");

                    $entities = $entityClass::offset($offset)->limit($limit)->get();

                    Log::channel($this->logger)->info("Total records in this batch: " . $entities->count());
                    $this->info("Total records in this batch: " . $entities->count());

                    try {
                        if (!$entities->count()) {
                            break;
                        }
                        /***
                         * Support to indexing a single record or multiple records
                         * Can be use like : 
                         * - With queue : EsMakeindexJob::dispatch($entities[0]);
                         * - With non-queue : app('es-makeindex')->initialize()->bulk($entities);
                         */
                        EsMakeindexJob::dispatch($entities);

                        /***
                         * Support to indexing a single record only
                         * Can be use like : 
                         * - With queue : EsMakeindexJob::dispatch($entities[0]);
                         * - With non-queue : app('es-makeindex')->initialize()->bulk($entities);
                         */

                        // EsMakeindexSingleJob::dispatch($entities[0]);
                        # code
                    } catch (\Throwable $e) {
                        $this->error($e->getMessage());
                    }
                    // ... progress bar
                    $this->output->progressAdvance();
                endfor; // end for
            } elseif ($action == 'remove' or $action == 'delete') {
                $this->error('Please use: php artisan elasticsearch:removeindex');
            } else {
                $this->error('Wrong action');
            }
            //
            $this->output->progressFinish();
            $this->info('Finished syncing data');
            Log::channel($this->logger)->info('Finished syncing data');
            // ...
            // END MAKE INDEX FOR ELASTICSEARCH
        } catch (\Throwable $e) {
            dd($e);
            $this->error($e->getMessage());
        }
        $this->info('====================================================================================');
        Log::channel($this->logger)->info('====================================================================================');

        return self::SUCCESS;
        #endregion indexing data
    }

    private function argumentIsValid($indexName): bool
    {
        if (
            $indexName === null ||
            !is_string($indexName) ||
            mb_strlen($indexName) === 0
        ) {
            $this->output->writeln(
                '<error>Argument index-name must be a non empty string.</error>'
            );

            return false;
        }

        return true;
    }
}

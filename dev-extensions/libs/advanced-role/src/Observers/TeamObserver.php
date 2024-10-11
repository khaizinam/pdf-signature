<?php

namespace Dev\AdvancedRole\Observers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Dev\AdvancedRole\Events\TeamEvent;
use Dev\AdvancedRole\Models\Team;

use Throwable;

class TeamObserver
{

    private $logger = 'advanced-role';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        try {
            $this->logger = apps_logger($this->logger);
        } catch (Throwable $th) {
            Log::channel($this->logger)->error($th->getMessage());
            Log::channel($this->logger)->error($th->getTraceAsString());
        }
    }

    public function setLog($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function saving(Team $team)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function creating(Team $team)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
        $team->name = Str::slug($team->name);

        // $team->author_id = $team->author_id ?: auth('member')->id();
        // $team->author_type = $team->author_type ?: User::class;
    }

    public function updated(Team $team)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function created(Team $team)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);

        // if (!app()->runningInConsole()) {
        //     event(new TeamEvent($team, $team->assigned, 'TeamAssigned'));
        // }
    }

    public function deleting(Team $team)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function deleted(Team $team)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
}

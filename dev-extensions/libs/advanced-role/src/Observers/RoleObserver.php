<?php

namespace Dev\AdvancedRole\Observers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Dev\AdvancedRole\Events\RoleEvent;
use Dev\AdvancedRole\Models\Role;

use Throwable;

class RoleObserver
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

    public function saving(Role $role)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function creating(Role $role)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
        $role->name = Str::slug($role->name);

        // $role->author_id = $role->author_id ?: auth('member')->id();
        // $role->author_type = $role->author_type ?: User::class;
    }

    public function updated(Role $role)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);

        // if (!app()->runningInConsole()) {
        //     event(new RoleEvent($role, $role->assigned, 'RoleAssigned'));
        // }    
    }

    public function created(Role $role)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);

        // if (!app()->runningInConsole()) {
        //     event(new RoleEvent($role, $role->assigned, 'RoleAssigned'));
        // }
    }

    public function deleting(Role $role)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function deleted(Role $role)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function permissionAdded($role, $permission)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
    public function permissionRemoved($role, $permission)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
    public function permissionSynced()
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
}

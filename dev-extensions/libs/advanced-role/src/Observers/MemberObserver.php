<?php

namespace Dev\AdvancedRole\Observers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Dev\AdvancedRole\Events\MemberEvent;
use Dev\AdvancedRole\Models\Member;

use Throwable;

class MemberObserver
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

    public function saving(Member $member)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function creating(Member $member)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
        $member->name = Str::slug($member->name);

        // $member ->author_id = $member ->author_id ?: auth('member')->id();
        // $member ->author_type = $member ->author_type ?: User::class;
    }

    public function updated(Member $member)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);

        // if (!app()->runningInConsole()) {
        //     event(new MemberEvent($member , $member ->assigned, 'MemberAssigned'));
        // }       
    }

    public function created(Member $member)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);

        // if (!app()->runningInConsole()) {
        //     event(new MemberEvent($member , $member ->assigned, 'MemberAssigned'));
        // }
    }

    public function deleting(Member $member)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function deleted(Member $member)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    /**
     * https://laratrust.santigarcor.me/docs/8.x/usage/events.html#available-events
     * 
     * Laratrust event
     */
    public function roleAdded(Member $user, $member, $team)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    /**
     * https://laratrust.santigarcor.me/docs/8.x/usage/events.html#available-events
     * 
     * Laratrust event
     */
    public function roleSynced(Member $user, $changes, $team)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }

    public function roleRemoved($user, $role, $team = null)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
    public function permissionAdded($user, $permission, $team = null)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
    public function permissionRemoved($user, $permission, $team = null)
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
    public function permissionSynced()
    {
        Log::channel($this->logger)->info("Observer calling: " . __CLASS__ . "::" . __FUNCTION__);
    }
}

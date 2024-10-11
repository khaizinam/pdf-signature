<?php

namespace Dev\AdvancedRole\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Dev\AdvancedRole\Models\Team;

class TeamEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notifyUser;
    public $notificationName;
    /**
     * @var Team
     */
    public $team;

    public function __construct(Team $team, $notifyUser, $notificationName)
    {
        $this->team = $team;
        $this->notifyUser = $notifyUser;
        $this->notificationName = $notificationName;
    }
}

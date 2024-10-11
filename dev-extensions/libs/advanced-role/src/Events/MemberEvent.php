<?php

namespace Dev\AdvancedRole\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Dev\AdvancedRole\Models\Member;

class MemberEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notifyUser;
    public $notificationName;
    /**
     * @var Member 
     */
    public $member;

    public function __construct(Member $member, $notifyUser, $notificationName)
    {
        $this->member  = $member;
        $this->notifyUser = $notifyUser;
        $this->notificationName = $notificationName;
    }
}

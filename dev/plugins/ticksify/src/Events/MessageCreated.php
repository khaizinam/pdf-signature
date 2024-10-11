<?php

namespace Dev\Ticksify\Events;

use Dev\Ticksify\Models\Message;
use Illuminate\Foundation\Events\Dispatchable;

class MessageCreated
{
    use Dispatchable;

    public function __construct(
        public Message $message
    ) {
    }
}

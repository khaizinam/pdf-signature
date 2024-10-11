<?php

namespace Dev\RequestLog\Events;

use Dev\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RequestHandlerEvent extends Event
{
    use SerializesModels;

    public function __construct(public int $code)
    {
    }
}

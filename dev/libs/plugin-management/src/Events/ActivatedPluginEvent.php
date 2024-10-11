<?php

namespace Dev\PluginManagement\Events;

use Dev\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class ActivatedPluginEvent extends Event
{
    use SerializesModels;

    public function __construct(public string $plugin)
    {
    }
}

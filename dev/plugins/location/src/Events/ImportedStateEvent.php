<?php

namespace Dev\Location\Events;

use Dev\Base\Events\Event;
use Dev\Location\Models\State;
use Illuminate\Queue\SerializesModels;

class ImportedStateEvent extends Event
{
    use SerializesModels;

    public function __construct(public array $row, public State $state)
    {
    }
}

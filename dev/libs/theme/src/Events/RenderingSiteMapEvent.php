<?php

namespace Dev\Theme\Events;

use Dev\Base\Events\Event;

class RenderingSiteMapEvent extends Event
{
    public function __construct(public ?string $key = null)
    {
    }
}

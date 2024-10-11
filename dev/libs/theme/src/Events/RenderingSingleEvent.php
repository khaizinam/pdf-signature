<?php

namespace Dev\Theme\Events;

use Dev\Base\Events\Event;
use Dev\Slug\Models\Slug;
use Illuminate\Queue\SerializesModels;

class RenderingSingleEvent extends Event
{
    use SerializesModels;

    public function __construct(public Slug $slug)
    {
    }
}

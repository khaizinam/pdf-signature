<?php

namespace Dev\Slug\Events;

use Dev\Base\Events\Event;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class UpdatedPermalinkSettings extends Event
{
    use SerializesModels;

    public function __construct(public string $reference, public string $prefix, public Request $request)
    {
    }
}

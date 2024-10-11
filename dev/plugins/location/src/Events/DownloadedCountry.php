<?php

namespace Dev\Location\Events;

use Dev\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class DownloadedCountry extends Event
{
    use SerializesModels;
}

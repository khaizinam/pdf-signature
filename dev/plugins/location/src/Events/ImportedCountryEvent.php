<?php

namespace Dev\Location\Events;

use Dev\Base\Events\Event;
use Dev\Location\Models\Country;
use Illuminate\Queue\SerializesModels;

class ImportedCountryEvent extends Event
{
    use SerializesModels;

    public function __construct(public array $row, public Country $country)
    {
    }
}

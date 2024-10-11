<?php

namespace Dev\Location\Events;

use Dev\Base\Events\Event;
use Dev\Location\Models\City;
use Illuminate\Queue\SerializesModels;

class ImportedCityEvent extends Event
{
    use SerializesModels;

    public function __construct(public array $row, public City $city)
    {
    }
}

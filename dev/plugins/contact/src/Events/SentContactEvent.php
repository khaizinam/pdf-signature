<?php

namespace Dev\Contact\Events;

use Dev\Base\Events\Event;
use Dev\Base\Models\BaseModel;
use Illuminate\Queue\SerializesModels;

class SentContactEvent extends Event
{
    use SerializesModels;

    public function __construct(public bool|BaseModel|null $data)
    {
    }
}

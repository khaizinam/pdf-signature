<?php

namespace Dev\Slug\Events;

use Dev\Base\Events\Event;
use Dev\Slug\Models\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatedSlugEvent extends Event
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public bool|Model|null $data, public Slug $slug)
    {
    }
}

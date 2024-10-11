<?php

namespace Dev\Slug\Listeners;

use Dev\Slug\Models\Slug;

class TruncateSlug
{
    public function handle(): void
    {
        Slug::query()->truncate();
    }
}

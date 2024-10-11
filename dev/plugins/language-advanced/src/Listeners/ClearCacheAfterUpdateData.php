<?php

namespace Dev\LanguageAdvanced\Listeners;

use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Models\BaseModel;
use Dev\Support\Services\Cache\Cache;

class ClearCacheAfterUpdateData
{
    public function handle(UpdatedContentEvent $event): void
    {
        if (! setting('enable_cache', false) || ! $event->data instanceof BaseModel) {
            return;
        }

        $cache = new Cache(app('cache'), $event->data::class);
        $cache->flush();
    }
}

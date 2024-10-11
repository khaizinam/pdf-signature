<?php

namespace Dev\Slug\Listeners;

use Dev\Base\Contracts\BaseModel;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Slug\Facades\SlugHelper;
use Dev\Slug\Models\Slug;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        if ($event->data instanceof BaseModel && SlugHelper::isSupportedModel($event->data::class)) {
            Slug::query()->where([
                'reference_id' => $event->data->getKey(),
                'reference_type' => $event->data::class,
            ])->delete();
        }
    }
}

<?php

namespace Dev\EditLock\Listeners;

use Dev\Base\Events\UpdatedContentEvent;
use EditLock;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        $model = $event->data;

        if (is_object($model) && EditLock::isSupportedModule(get_class($model))) {
            EditLock::deleteMetaData($model);
        }
    }
}

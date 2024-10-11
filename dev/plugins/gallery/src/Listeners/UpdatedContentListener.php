<?php

namespace Dev\Gallery\Listeners;

use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\Gallery\Facades\Gallery;
use Exception;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        try {
            Gallery::saveGallery($event->request, $event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

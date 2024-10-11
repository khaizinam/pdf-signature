<?php

namespace Dev\Gallery\Listeners;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\Gallery\Facades\Gallery;
use Exception;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event): void
    {
        try {
            Gallery::saveGallery($event->request, $event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

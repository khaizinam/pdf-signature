<?php

namespace Dev\Gallery\Listeners;

use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\Gallery\Facades\Gallery;
use Exception;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            Gallery::deleteGallery($event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

<?php

namespace Dev\SeoHelper\Listeners;

use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\SeoHelper\Facades\SeoHelper;
use Exception;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            SeoHelper::deleteMetaData($event->screen, $event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

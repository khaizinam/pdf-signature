<?php

namespace Dev\SeoHelper\Listeners;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\SeoHelper\Facades\SeoHelper;
use Exception;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event): void
    {
        try {
            SeoHelper::saveMetaData($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

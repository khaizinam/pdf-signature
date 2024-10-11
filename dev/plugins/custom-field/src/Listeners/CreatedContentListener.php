<?php

namespace Dev\CustomField\Listeners;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\CustomField\Facades\CustomField;
use Exception;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event): void
    {
        try {
            CustomField::saveCustomFields($event->request, $event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

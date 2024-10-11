<?php

namespace Dev\CustomField\Listeners;

use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\CustomField\Facades\CustomField;
use Exception;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        try {
            CustomField::saveCustomFields($event->request, $event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

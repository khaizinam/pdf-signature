<?php

namespace Dev\CustomField\Listeners;

use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\CustomField\Facades\CustomField;
use Exception;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            CustomField::deleteCustomFields($event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

<?php

namespace Dev\Language\Listeners;

use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\Language\Facades\Language;
use Exception;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            Language::deleteLanguage($event->screen, $event->data);
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

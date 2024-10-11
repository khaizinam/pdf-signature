<?php

namespace Dev\Language\Listeners;

use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\Language\Facades\Language;
use Exception;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        try {
            if ($event->request->input('language')) {
                Language::saveLanguage($event->screen, $event->request, $event->data);
            }
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

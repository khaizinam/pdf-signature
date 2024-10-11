<?php

namespace Dev\AuditLog\Listeners;

use Dev\AuditLog\Events\AuditHandlerEvent;
use Dev\AuditLog\Facades\AuditLog;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Exception;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            if ($event->data->getKey()) {
                $model = $event->screen;

                event(new AuditHandlerEvent(
                    $model,
                    'deleted',
                    $event->data->getKey(),
                    AuditLog::getReferenceName($model, $event->data),
                    'danger'
                ));
            }
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

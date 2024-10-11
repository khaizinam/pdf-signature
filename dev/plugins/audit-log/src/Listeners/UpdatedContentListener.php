<?php

namespace Dev\AuditLog\Listeners;

use Dev\AuditLog\Events\AuditHandlerEvent;
use Dev\AuditLog\Facades\AuditLog;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        try {
            if ($event->data->getKey()) {
                $model = $event->screen;

                if ($model === 'form') {
                    $model = strtolower(Str::afterLast(get_class($event->data), '\\'));
                }

                event(new AuditHandlerEvent(
                    $model,
                    $model === 'user' && $event->data->getKey() == Auth::id() ? 'has updated his profile' : 'updated',
                    $event->data->getKey(),
                    AuditLog::getReferenceName($model, $event->data),
                    'primary'
                ));
            }
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

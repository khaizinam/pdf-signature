<?php

namespace Dev\Menu\Listeners;

use Dev\Base\Contracts\BaseModel;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Menu\Facades\Menu;
use Dev\Menu\Models\MenuNode;

class DeleteMenuNodeListener
{
    public function handle(DeletedContentEvent $event): void
    {
        if (
            ! $event->data instanceof BaseModel ||
            ! in_array($event->data::class, Menu::getMenuOptionModels())
        ) {
            return;
        }

        MenuNode::query()
            ->where([
                'reference_id' => $event->data->getKey(),
                'reference_type' => $event->data::class,
            ])
            ->delete();
    }
}

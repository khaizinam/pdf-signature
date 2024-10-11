<?php

namespace Dev\Widget\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dev\Widget\WidgetGroup group(string $sidebarId)
 * @method static \Dev\Widget\WidgetGroupCollection setGroup(array $args)
 * @method static \Dev\Widget\WidgetGroupCollection removeGroup(string $groupId)
 * @method static array getGroups()
 * @method static string render(string $sidebarId)
 * @method static void load(bool $force = false)
 * @method static \Illuminate\Support\Collection getData()
 *
 * @see \Dev\Widget\WidgetGroupCollection
 */
class WidgetGroup extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'apps.widget-group-collection';
    }
}

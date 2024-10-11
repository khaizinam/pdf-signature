<?php

namespace Dev\PostScheduler\Facades;

use Dev\PostScheduler\Supports\PostScheduler as BasePostScheduler;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dev\PostScheduler\Supports\PostScheduler registerModule(array|string $model)
 * @method static array supportedModules()
 * @method static bool isSupportedModule(string $model)
 *
 * @see \Dev\PostScheduler\Supports\PostScheduler
 */
class PostScheduler extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BasePostScheduler::class;
    }
}

<?php

namespace Dev\Optimize\Facades;

use Dev\Optimize\Supports\Optimizer;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled()
 * @method static \Dev\Optimize\Supports\Optimizer enable()
 * @method static \Dev\Optimize\Supports\Optimizer disable()
 *
 * @see \Dev\Optimize\Supports\Optimizer
 */
class OptimizerHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Optimizer::class;
    }
}

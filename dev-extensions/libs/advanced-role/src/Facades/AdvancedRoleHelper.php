<?php

namespace Dev\AdvancedRole\Facades;

use Dev\AdvancedRole\Supports\AdvancedRoleHelper as AdvancedRoleHelperSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool enabled()
 *
 * @see \Dev\AdvancedRole\Supports\AdvancedRoleHelper
 */
class AdvancedRoleHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AdvancedRoleHelperSupport::class;
    }
}

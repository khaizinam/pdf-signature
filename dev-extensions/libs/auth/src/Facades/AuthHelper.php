<?php

namespace Dev\Auth\Facades;

use Dev\Auth\Supports\AuthHelper as AuthHelperSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null guard()
 * @method static string|null passwordBroker()
 * @method static boolean|null accountVerify()
 * @method static bool enabled()
 *
 * @see \Dev\Auth\Supports\AuthHelper
 */
class AuthHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AuthHelperSupport::class;
    }
}

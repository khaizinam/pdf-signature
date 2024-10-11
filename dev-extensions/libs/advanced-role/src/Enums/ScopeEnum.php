<?php

namespace Dev\AdvancedRole\Enums;

use Dev\Base\Supports\Enum;

/**
 * @method static PermissionScopeEnum NONE()
 * @method static PermissionScopeEnum BASIC()
 * @method static PermissionScopeEnum LOCAL()
 * @method static PermissionScopeEnum DEEP()
 * @method static PermissionScopeEnum GLOBAL()
 */
class ScopeEnum extends Enum
{
    public const NONE = 'none';
    public const BASIC = 'basic';
    public const LOCAL = 'local';
    public const DEEP = 'deep';
    public const GLOBAL = 'global';

    /**
     * @var string
     */
    public static $langPath = 'plugins/advanced-role::enums.statuses';
}

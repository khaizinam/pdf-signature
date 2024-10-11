<?php

namespace Dev\AdvancedRole\Traits;

use Dev\AdvancedRole\Supports\PermissionHelper;

trait PermissionQueryBuilderScope
{
    /**
     * THIS IS LOCAL SCOPE: it's begin with scope like: scope[YourPurpose]
     * 
     * This traits built for your Local Scope only (can not use for global scope, dynamic scope)
     * You can defines more local scope in this file, then use as a Trait class in your models.
     * 
     * @name scopeApplyScopeBeforeQuery
     *  @usage: applyScopeBeforeQuery
     * @desc attach to model by trait
     */

    public function scopeApplyScopeBeforeQuery($query, $request = null, $action, callable $payload = null)
    {
        $entityName = get_class($query->getModel());

        $departmentIds = PermissionHelper::departmentsOfUser($entityName, $action);

        $scopePermission = PermissionHelper::queryPermission($entityName, $action)->scope ?? null;

        return $query = $payload ? $payload($query, $departmentIds, $scopePermission) : $query->applyPermissionsBeforeQuery($departmentIds, $scopePermission);
    }
}

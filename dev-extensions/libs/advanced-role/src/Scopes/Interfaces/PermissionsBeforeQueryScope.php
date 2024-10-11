<?php

namespace Dev\AdvancedRole\Scopes\Interfaces;

/**
 * THIS IS LOCAL SCOPE: it's begin with scope like: scope[YourPurpose]
 * 
 * This interface built for your Local Scope only (can not use for global scope, dynamic scope)
 * Just implements this interface on your Model and re-write bellow local scope with your new logics
 * 
 * @name scopeApplyPermissionsBeforeQuery
 *  @usage: applyPermissionsBeforeQuery
 * @desc Need rewrite on each model
 */
interface PermissionsBeforeQueryScope
{
    public function scopeApplyPermissionsBeforeQuery($query, $departmentIds, $scope = null);

    public function scopeApplyVisibility($query);
}

<?php

namespace Dev\AdvancedRole\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Scope;
use Dev\AdvancedRole\Models\Permission;

class PermissionRole extends Pivot
{
    protected $table = 'app__permission_roles';

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class, 'scope');
    }
}

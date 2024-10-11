<?php

namespace Dev\AdvancedRole\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Scope;
use Dev\AdvancedRole\Models\Permission;
use Dev\AdvancedRole\Models\Team;
use Dev\AdvancedRole\Models\Member;

class PermissionMember extends Pivot
{
    protected $table = 'app__permission_members';

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}

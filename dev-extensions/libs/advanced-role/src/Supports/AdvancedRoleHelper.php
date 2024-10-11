<?php

namespace Dev\AdvancedRole\Supports;

use Illuminate\Database\Eloquent\Model;


use Dev\Base\Models\BaseModel;
use Dev\AdvancedRole\Models\Member;

class AdvancedRoleHelper
{
    public function enabled(): bool
    {
        return setting('advanced-role_enabled', 0) == 1;
    }
}

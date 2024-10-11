<?php

namespace Dev\AdvancedRole\Models;


use Dev\Base\Contracts\BaseModel;
use Dev\Base\Models\Concerns\HasBaseEloquentBuilder;
use Dev\Base\Models\Concerns\HasMetadata;
use Dev\Base\Models\Concerns\HasUuidsOrIntegerIds;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken implements BaseModel
{
    use HasMetadata;
    use HasUuidsOrIntegerIds;
    use HasBaseEloquentBuilder;
}

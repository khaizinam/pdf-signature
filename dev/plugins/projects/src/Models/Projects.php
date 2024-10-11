<?php

namespace Dev\Projects\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;

/**
 * @method static \Dev\Base\Models\BaseQueryBuilder<static> query()
 */
class Projects extends BaseModel
{
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];
}

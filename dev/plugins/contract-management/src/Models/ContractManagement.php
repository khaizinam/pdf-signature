<?php

namespace Dev\ContractManagement\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;

/**
 * @method static \Dev\Base\Models\BaseQueryBuilder<static> query()
 */
class ContractManagement extends BaseModel
{
    protected $table = 'contract_managements';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];
}

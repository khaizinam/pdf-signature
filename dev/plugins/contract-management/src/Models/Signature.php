<?php

namespace Dev\ContractManagement\Models;

use Dev\ACL\Models\User;
use Dev\Base\Casts\SafeContent;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;

/**
 * @method static \Dev\Base\Models\BaseQueryBuilder<static> query()
 */
class Signature extends BaseModel
{
    protected $table = 'signatures';

    protected $fillable = [
        'name',
        'status',
        'contract_id',
        'file',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];

    public function contract()
    {
        return $this->belongsTo(ContractManagement::class, 'contract_id');
    }
}

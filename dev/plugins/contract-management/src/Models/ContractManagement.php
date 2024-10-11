<?php

namespace Dev\ContractManagement\Models;

use Dev\ACL\Models\User;
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
        'description',
        'status',
        'user_id',
        'file',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class, 'contract_id')->orderBy("created_at");
    }
}

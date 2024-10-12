<?php

namespace Dev\ContractManagement\Models;

use Dev\Base\Models\BaseModel;

/**
 * @method static \Dev\Base\Models\BaseQueryBuilder<static> query()
 */
class SignatureContract extends BaseModel
{
    protected $table = 'signature_contract';

    protected $fillable = [
        'signature_id',
        'contract_id',
    ];

    public function signature()
    {
        return $this->belongsTo(Signature::class, 'signature_id');
    }

    public function contract()
    {
        return $this->belongsTo(ContractManagement::class, 'contract_id');
    }
}

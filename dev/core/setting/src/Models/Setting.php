<?php

namespace Dev\Setting\Models;

use Dev\Base\Models\BaseModel;

class Setting extends BaseModel
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];
}

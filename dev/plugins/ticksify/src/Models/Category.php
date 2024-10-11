<?php

namespace Dev\Ticksify\Models;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;

class Category extends BaseModel
{
    protected $table = 'fob_ticket_categories';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}

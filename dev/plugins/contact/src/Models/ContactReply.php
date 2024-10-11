<?php

namespace Dev\Contact\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Models\BaseModel;

class ContactReply extends BaseModel
{
    protected $table = 'contact_replies';

    protected $fillable = [
        'message',
        'contact_id',
    ];

    protected $casts = [
        'message' => SafeContent::class,
    ];
}

<?php

namespace Dev\Gallery\Models;

use Dev\ACL\Models\User;
use Dev\Base\Casts\SafeContent;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends BaseModel
{
    protected $table = 'galleries';

    protected $fillable = [
        'name',
        'description',
        'is_featured',
        'order',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}

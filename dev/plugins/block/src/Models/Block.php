<?php

namespace Dev\Block\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Dev\Base\Models\Concerns\HasSlug;

class Block extends BaseModel
{
    use HasSlug;

    protected $table = 'blocks';

    protected $fillable = [
        'name',
        'alias',
        'description',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'content' => SafeContent::class,
        'description' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        self::saving(function (self $model) {
            $model->alias = self::createSlug($model->alias, $model->getKey(), 'alias');
        });
    }
}

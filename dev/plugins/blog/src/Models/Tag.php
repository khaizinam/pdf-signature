<?php

namespace Dev\Blog\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends BaseModel
{
    protected $table = 'tags';

    protected $fillable = [
        'name',
        'description',
        'status',
        'author_id',
        'author_type',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        static::deleted(function (Tag $tag) {
            $tag->posts()->detach();
        });
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }
}

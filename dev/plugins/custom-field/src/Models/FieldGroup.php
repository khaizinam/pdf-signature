<?php

namespace Dev\CustomField\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldGroup extends BaseModel
{
    protected $table = 'field_groups';

    protected $fillable = [
        'order',
        'rules',
        'title',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'title' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        self::deleting(function (FieldGroup $fieldGroup) {
            $fieldGroup->fieldItems()->each(fn (FieldItem $item) => $item->delete());
        });
    }

    public function fieldItems(): HasMany
    {
        return $this->hasMany(FieldItem::class, 'field_group_id');
    }
}

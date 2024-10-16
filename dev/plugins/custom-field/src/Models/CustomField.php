<?php

namespace Dev\CustomField\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CustomField extends BaseModel
{
    public $timestamps = false;

    protected $table = 'custom_fields';

    protected $fillable = [
        'use_for',
        'use_for_id',
        'parent_id',
        'type',
        'slug',
        'value',
        'field_item_id',
    ];

    protected $casts = [
        'slug' => SafeContent::class,
    ];

    public function useCustomFields(): MorphTo
    {
        return $this->morphTo()->withDefault();
    }

    protected function resolvedValue(): Attribute
    {
        return Attribute::get(function () {
            $value = $this->value;

            if ($this->type === 'repeater') {
                $value = json_decode((string) $this->value, true);
            }

            return $value;
        });
    }
}

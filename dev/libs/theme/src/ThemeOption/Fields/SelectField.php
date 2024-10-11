<?php

namespace Dev\Theme\ThemeOption\Fields;

use Dev\Theme\Concerns\ThemeOption\Fields\HasOptions;
use Dev\Theme\ThemeOption\ThemeOptionField;

class SelectField extends ThemeOptionField
{
    use HasOptions;

    public function fieldType(): string
    {
        return 'customSelect';
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'attributes' => [
                ...parent::toArray()['attributes'],
                'choices' => $this->options,
            ],
        ];
    }
}

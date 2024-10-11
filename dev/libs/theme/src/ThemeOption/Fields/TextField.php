<?php

namespace Dev\Theme\ThemeOption\Fields;

use Dev\Theme\ThemeOption\ThemeOptionField;

class TextField extends ThemeOptionField
{
    public function fieldType(): string
    {
        return 'text';
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'attributes' => [
                ...parent::toArray()['attributes'],
                'value' => $this->getValue(),
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ];
    }
}

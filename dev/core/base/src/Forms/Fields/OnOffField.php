<?php

namespace Dev\Base\Forms\Fields;

use Dev\Base\Forms\FieldTypes\FormField;

class OnOffField extends FormField
{
    protected bool $useDefaultFieldClass = false;

    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.on-off';
    }
}

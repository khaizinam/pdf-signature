<?php

namespace Dev\Slug\Forms\Fields;

use Dev\Base\Forms\FormField;

class PermalinkField extends FormField
{
    protected function getTemplate(): string
    {
        return 'libs/slug::forms.fields.permalink';
    }
}

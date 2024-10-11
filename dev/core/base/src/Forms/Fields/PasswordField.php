<?php

namespace Dev\Base\Forms\Fields;

use Dev\Base\Forms\FormField;

class PasswordField extends FormField
{
    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.password';
    }
}

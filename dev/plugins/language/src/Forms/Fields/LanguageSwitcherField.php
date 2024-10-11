<?php

namespace Dev\Language\Forms\Fields;

use Dev\Base\Forms\FormField;

class LanguageSwitcherField extends FormField
{
    protected function getTemplate(): string
    {
        return 'plugins/language::forms.fields.language-switcher';
    }
}

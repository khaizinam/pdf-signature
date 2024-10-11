<?php

namespace Dev\Theme\Forms\Fields;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FormField;

class ThemeIconField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScriptsDirectly('vendor/core/libs/theme/js/icons-field.js');

        return 'libs/theme::fields.icons-field';
    }
}

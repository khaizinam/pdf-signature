<?php

namespace Dev\Base\Forms\Fields;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FormField;

class TagField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addStyles('tagify')
            ->addScripts('tagify')
            ->addScriptsDirectly('vendor/core/core/base/js/tags.js');

        return 'core/base::forms.fields.tags';
    }
}

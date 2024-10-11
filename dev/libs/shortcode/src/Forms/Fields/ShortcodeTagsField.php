<?php

namespace Dev\Shortcode\Forms\Fields;

use Dev\Base\Facades\Assets;
use Dev\Base\Facades\Html;
use Dev\Base\Forms\FormField;

class ShortcodeTagsField extends FormField
{
    protected function getTemplate(): string
    {
        return 'libs/shortcode::forms.fields.tags';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true): string
    {
        return Assets::styleToHtml('tagify') .
            Assets::scriptToHtml('tagify') .
            Html::script('vendor/core/core/base/js/tags.js') .
            parent::render($options, $showLabel, $showField, $showError);
    }
}

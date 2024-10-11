<?php

namespace Dev\Member\Forms\Fields;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Supports\Editor;
use Illuminate\Support\Arr;

class CustomEditorField extends TextareaField
{
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true): string
    {
        (new Editor())->registerAssets();

        Arr::set(
            $options,
            'attr.class',
            Arr::get($options, 'attr.class') . ' form-control editor-' . BaseHelper::getRichEditor()
        );

        return parent::render($options, $showLabel, $showField, $showError);
    }
}

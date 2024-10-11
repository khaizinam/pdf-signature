<?php

namespace Dev\Blog\Forms\Fields;

use Dev\Base\Forms\FormField;

/**
 * @deprecated
 */
class CategoryMultiField extends FormField
{
    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.tree-categories';
    }
}

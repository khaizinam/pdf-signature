<?php

namespace Dev\Base\Forms\Fields;

class EmailField extends TextField
{
    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.email';
    }
}

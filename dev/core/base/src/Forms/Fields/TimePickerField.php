<?php

namespace Dev\Base\Forms\Fields;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FormField;

class TimePickerField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScripts(['timepicker'])
            ->addStyles(['timepicker']);

        return 'core/base::forms.fields.time-picker';
    }
}

<?php

namespace Dev\Theme\ThemeOption\Fields;

use Dev\Theme\ThemeOption\ThemeOptionField;

class MediaImageField extends ThemeOptionField
{
    public function fieldType(): string
    {
        return 'mediaImage';
    }
}

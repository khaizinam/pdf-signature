<?php

namespace Dev\Location\Fields\Options;

use Dev\Base\Forms\FormFieldOptions;

class SelectLocationFieldOption extends FormFieldOptions
{
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['wrapperClassName'] = 'mb-3 row';

        $colspan = $this->getColspan() ?: 3;

        if ($colspan > 0) {
            $data['wrapper']['class'] = 'col-md-' . (12 / $colspan);
        }

        return $data;
    }
}

<?php

namespace Dev\Base\Forms\FieldTypes;

use Dev\Base\Traits\Forms\CanSpanColumns;

class TextareaType extends \Kris\LaravelFormBuilder\Fields\TextareaType
{
    use CanSpanColumns;
}

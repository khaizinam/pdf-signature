<?php

namespace Dev\Base\Forms\FieldTypes;

use Dev\Base\Traits\Forms\CanSpanColumns;

class ChoiceType extends \Kris\LaravelFormBuilder\Fields\ChoiceType
{
    use CanSpanColumns;
}

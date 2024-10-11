<?php

namespace Dev\Base\Forms\FieldTypes;

use Dev\Base\Traits\Forms\CanSpanColumns;

class InputType extends \Kris\LaravelFormBuilder\Fields\InputType
{
    use CanSpanColumns;
}

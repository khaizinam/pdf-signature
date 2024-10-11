<?php

namespace Dev\Base\Forms\FieldTypes;

use Dev\Base\Traits\Forms\CanSpanColumns;

class CheckableType extends \Kris\LaravelFormBuilder\Fields\CheckableType
{
    use CanSpanColumns;
}

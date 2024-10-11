<?php

namespace Dev\Base\Forms\FieldTypes;

use Dev\Base\Traits\Forms\CanSpanColumns;

class RepeatedType extends \Kris\LaravelFormBuilder\Fields\RepeatedType
{
    use CanSpanColumns;
}

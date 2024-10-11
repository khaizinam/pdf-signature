<?php

namespace Dev\Base\Forms\FieldTypes;

use Dev\Base\Traits\Forms\CanSpanColumns;

class ChildFormType extends \Kris\LaravelFormBuilder\Fields\ChildFormType
{
    use CanSpanColumns;
}

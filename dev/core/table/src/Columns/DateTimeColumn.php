<?php

namespace Dev\Table\Columns;

use Dev\Base\Facades\BaseHelper;

class DateTimeColumn extends DateColumn
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data, $name)
            ->dateFormat(BaseHelper::getDateTimeFormat())
            ->width(150);
    }
}

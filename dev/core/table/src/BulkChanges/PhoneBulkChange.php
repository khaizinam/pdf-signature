<?php

namespace Dev\Table\BulkChanges;

use Dev\Base\Facades\BaseHelper;
use Dev\Table\Abstracts\TableBulkChangeAbstract;

class PhoneBulkChange extends TableBulkChangeAbstract
{
    public static function make(array $data = []): static
    {
        return parent::make()
            ->name('phone')
            ->title(trans('core/base::tables.phone'))
            ->type('text')
            ->validate('required|' . BaseHelper::getPhoneValidationRule());
    }
}

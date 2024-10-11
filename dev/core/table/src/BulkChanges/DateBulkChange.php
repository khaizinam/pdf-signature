<?php

namespace Dev\Table\BulkChanges;

use Dev\Table\Abstracts\TableBulkChangeAbstract;

class DateBulkChange extends TableBulkChangeAbstract
{
    public static function make(array $data = []): static
    {
        return parent::make()
            ->type('date')
            ->validate(['required', 'string', 'date']);
    }
}

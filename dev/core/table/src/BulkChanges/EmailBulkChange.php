<?php

namespace Dev\Table\BulkChanges;

use Dev\Table\Abstracts\TableBulkChangeAbstract;

class EmailBulkChange extends TableBulkChangeAbstract
{
    public static function make(array $data = []): static
    {
        return parent::make()
            ->name('email')
            ->title(trans('core/base::tables.email'))
            ->type('text')
            ->validate(['required', 'max:120', 'email']);
    }
}

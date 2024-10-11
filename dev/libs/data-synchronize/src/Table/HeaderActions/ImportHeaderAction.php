<?php

namespace Dev\DataSynchronize\Table\HeaderActions;

use Dev\Table\HeaderActions\HeaderAction;

class ImportHeaderAction extends HeaderAction
{
    public static function make(string $name = 'import'): static
    {
        return parent::make($name)
            ->label(trans('libs/data-synchronize::data-synchronize.import.name'))
            ->icon('ti ti-file-import');
    }
}

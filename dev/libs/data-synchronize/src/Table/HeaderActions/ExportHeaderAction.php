<?php

namespace Dev\DataSynchronize\Table\HeaderActions;

use Dev\Table\HeaderActions\HeaderAction;

class ExportHeaderAction extends HeaderAction
{
    public static function make(string $name = 'export'): static
    {
        return parent::make($name)
            ->label(trans('libs/data-synchronize::data-synchronize.export.name'))
            ->icon('ti ti-file-export');
    }
}

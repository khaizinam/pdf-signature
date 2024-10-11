<?php

namespace Dev\CustomField\Tables\Actions;

use Dev\Table\Actions\Action;

class ExportAction extends Action
{
    public static function make(string $name = 'export'): static
    {
        return parent::make($name)
            ->label(trans('plugins/custom-field::base.export'))
            ->color('info')
            ->icon('ti ti-download');
    }
}

<?php

namespace Dev\Table\Columns;

use Dev\Base\Facades\Html;
use Dev\Table\Columns\Concerns\HasLink;
use Dev\Table\Contracts\FormattedColumn as FormattedColumnContract;

class EmailColumn extends FormattedColumn implements FormattedColumnContract
{
    use HasLink;

    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data ?: 'email', $name)
            ->title(trans('core/base::tables.email'))
            ->alignStart();
    }

    public function formattedValue($value): ?string
    {
        if (! $this->isLinkable() || ! $value) {
            return null;
        }

        return Html::mailto($value, $value, [], true, false);
    }
}

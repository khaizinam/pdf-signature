<?php

namespace Dev\Widget\Forms;

use Dev\Base\Forms\FormAbstract;
use Dev\Base\Models\BaseModel;

class WidgetForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(BaseModel::class)
            ->contentOnly();
    }

    public function renderForm(array $options = [], bool $showStart = false, bool $showFields = true, bool $showEnd = false): string
    {
        return parent::renderForm($options, $showStart, $showFields, $showEnd);
    }
}

<?php

namespace Dev\Blog\Widgets\Fronts;

use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\NumberFieldOption;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Widget\AbstractWidget;
use Dev\Widget\Forms\WidgetForm;
use Illuminate\Support\Collection;

class Tags extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Tags'),
            'description' => __('Popular tags'),
            'number_display' => 5,
        ]);
    }

    protected function data(): array|Collection
    {
        return [
            'tags' => get_popular_tags((int) $this->getConfig('number_display')),
        ];
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add('name', TextField::class, NameFieldOption::make()->toArray())
            ->add(
                'number_display',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(__('Number tags to display'))
                    ->toArray()
            );
    }

    protected function requiredPlugins(): array
    {
        return ['blog'];
    }
}

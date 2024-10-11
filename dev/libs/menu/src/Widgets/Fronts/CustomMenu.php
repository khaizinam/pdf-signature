<?php

namespace Dev\Menu\Widgets\Fronts;

use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Menu\Models\Menu;
use Dev\Widget\AbstractWidget;
use Dev\Widget\Forms\WidgetForm;

class CustomMenu extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Custom Menu'),
            'description' => __('Add a custom menu to your widget area.'),
            'menu_id' => null,
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add('name', TextField::class, NameFieldOption::make()->toArray())
            ->add(
                'menu_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Menu'))
                    ->choices(Menu::query()->pluck('name', 'slug')->all())
                    ->searchable()
                    ->toArray()
            );
    }
}

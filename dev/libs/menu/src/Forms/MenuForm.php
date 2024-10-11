<?php

namespace Dev\Menu\Forms;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Menu\Http\Requests\MenuRequest;
use Dev\Menu\Models\Menu;

class MenuForm extends FormAbstract
{
    public function setup(): void
    {
        Assets::addStyles('jquery-nestable')
            ->addScripts('jquery-nestable')
            ->addScriptsDirectly('vendor/core/libs/menu/js/menu.js')
            ->addStylesDirectly('vendor/core/libs/menu/css/menu.css');

        $this
            ->model(Menu::class)
            ->setFormOption('class', 'form-save-menu')
            ->setValidatorClass(MenuRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->maxLength(120)->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->addMetaBoxes([
                'structure' => [
                    'wrap' => false,
                    'content' => function () {
                        /**
                         * @var Menu $menu
                         */
                        $menu = $this->getModel();

                        return view('libs/menu::menu-structure', [
                            'menu' => $menu,
                            'locations' => $menu->getKey() ? $menu->locations()->pluck('location')->all() : [],
                        ])->render();
                    },
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}

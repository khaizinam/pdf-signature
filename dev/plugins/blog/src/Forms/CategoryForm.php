<?php

namespace Dev\Blog\Forms;

use Dev\Base\Forms\FieldOptions\DescriptionFieldOption;
use Dev\Base\Forms\FieldOptions\IsDefaultFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\CoreIconField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Blog\Http\Requests\CategoryRequest;
use Dev\Blog\Models\Category;

class CategoryForm extends FormAbstract
{
    public function setup(): void
    {
        $list = get_categories(['condition' => []]);

        $categories = [];
        foreach ($list as $row) {
            if ($this->getModel() && ($this->model->id === $row->id || $this->model->id === $row->parent_id)) {
                continue;
            }

            $categories[$row->id] = $row->indent_text . ' ' . $row->name;
        }

        $categories = [0 => trans('plugins/blog::categories.none')] + $categories;

        $maxOrder = Category::query()
            ->whereIn('parent_id', [0, null])
            ->orderByDesc('order')
            ->value('order');

        $this
            ->model(Category::class)
            ->setValidatorClass(CategoryRequest::class)
            ->add('order', 'hidden', [
                'value' => $this->getModel()->exists ? $this->getModel()->order : $maxOrder + 1,
            ])
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add(
                'parent_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('core/base::forms.parent'))
                    ->choices($categories)
                    ->searchable()
                    ->toArray()
            )
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('is_default', OnOffField::class, IsDefaultFieldOption::make()->toArray())
            ->add(
                'icon',
                $this->getFormHelper()->hasCustomField('themeIcon') ? 'themeIcon' : CoreIconField::class,
                TextFieldOption::make()
                    ->label(trans('core/base::forms.icon'))
                    ->placeholder(trans('core/base::forms.icon_placeholder'))
                    ->addAttribute('data-allow-clear', 'true')
                    ->maxLength(120)
                    ->toArray()
            )
            ->add(
                'is_featured',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('core/base::forms.is_featured'))
                    ->defaultValue(false)
                    ->toArray()
            )
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->setBreakFieldPoint('status');
    }
}

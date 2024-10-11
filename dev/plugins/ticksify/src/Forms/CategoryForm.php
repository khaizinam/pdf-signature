<?php

namespace Dev\Ticksify\Forms;

use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Ticksify\Http\Requests\CategoryRequest;
use Dev\Ticksify\Models\Category;

class CategoryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Category::class)
            ->setValidatorClass(CategoryRequest::class)
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->required()
                    ->maxLength(255),
            )
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make(),
            );
    }
}

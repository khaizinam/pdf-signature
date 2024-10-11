<?php

namespace Dev\Blog\Forms;

use Dev\Base\Forms\FieldOptions\DescriptionFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Blog\Http\Requests\TagRequest;
use Dev\Blog\Models\Tag;

class TagForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Tag::class)
            ->setValidatorClass(TagRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->maxLength(120)->toArray())
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->setBreakFieldPoint('status');
    }
}

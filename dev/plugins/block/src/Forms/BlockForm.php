<?php

namespace Dev\Block\Forms;

use Dev\Base\Forms\FieldOptions\ContentFieldOption;
use Dev\Base\Forms\FieldOptions\DescriptionFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\EditorField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Block\Http\Requests\BlockRequest;
use Dev\Block\Models\Block;

class BlockForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Block::class)
            ->setValidatorClass(BlockRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add(
                'alias',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('core/base::forms.alias'))
                    ->placeholder(trans('core/base::forms.alias_placeholder'))
                    ->required()
                    ->maxLength(120)
                    ->toArray()
            )
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('content', EditorField::class, ContentFieldOption::make()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->setBreakFieldPoint('status');
    }
}

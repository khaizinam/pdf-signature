<?php

namespace Dev\Gallery\Forms;

use Dev\Base\Forms\FieldOptions\EditorFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\FieldOptions\SortOrderFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\EditorField;
use Dev\Base\Forms\Fields\MediaImageField;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Gallery\Http\Requests\GalleryRequest;
use Dev\Gallery\Models\Gallery;

class GalleryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Gallery::class)
            ->setValidatorClass(GalleryRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('description', EditorField::class, EditorFieldOption::make()->required()->toArray())
            ->add('order', NumberField::class, SortOrderFieldOption::make()->toArray())
            ->add(
                'is_featured',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('core/base::forms.is_featured'))
                    ->defaultValue(false)
                    ->toArray()
            )
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->add('image', MediaImageField::class)
            ->setBreakFieldPoint('status');
    }
}

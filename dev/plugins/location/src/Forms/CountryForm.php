<?php

namespace Dev\Location\Forms;

use Dev\Base\Forms\FieldOptions\IsDefaultFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\SortOrderFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Location\Http\Requests\CountryRequest;
use Dev\Location\Models\Country;

class CountryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Country::class)
            ->setValidatorClass(CountryRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('code', TextField::class, [
                'label' => trans('plugins/location::country.code'),
                'attr' => [
                    'placeholder' => trans('plugins/location::country.code_placeholder'),
                    'data-counter' => 10,
                ],
                'help_block' => [
                    'text' => trans('plugins/location::country.code_helper'),
                ],
            ])
            ->add('nationality', TextField::class, [
                'label' => trans('plugins/location::country.nationality'),
                'attr' => [
                    'placeholder' => trans('plugins/location::country.nationality'),
                    'data-counter' => 120,
                ],
            ])
            ->add('order', NumberField::class, SortOrderFieldOption::make()->toArray())
            ->add('is_default', OnOffField::class, IsDefaultFieldOption::make()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->setBreakFieldPoint('status');
    }
}

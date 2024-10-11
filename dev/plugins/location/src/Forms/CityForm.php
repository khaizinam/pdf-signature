<?php

namespace Dev\Location\Forms;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FieldOptions\IsDefaultFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\SortOrderFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\MediaImageField;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Location\Http\Requests\CityRequest;
use Dev\Location\Models\City;
use Dev\Location\Models\Country;

class CityForm extends FormAbstract
{
    public function setup(): void
    {
        Assets::addScriptsDirectly('vendor/core/plugins/location/js/location.js');

        $countries = Country::query()->pluck('name', 'id')->all();

        $states = [];
        if ($this->getModel()) {
            $states = $this->getModel()->country->states()->pluck('name', 'id')->all();
        }

        $this
            ->model(City::class)
            ->setValidatorClass(CityRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('slug', TextField::class, [
                'label' => __('Slug'),
                'attr' => [
                    'placeholder' => __('Slug'),
                    'data-counter' => 120,
                ],
            ])
            ->add('country_id', SelectField::class, [
                'label' => trans('plugins/location::city.country'),
                'required' => true,
                'attr' => [
                    'id' => 'country_id',
                    'class' => 'select-search-full',
                    'data-type' => 'country',
                ],
                'choices' => [0 => trans('plugins/location::city.select_country')] + $countries,
            ])
            ->add('state_id', SelectField::class, [
                'label' => trans('plugins/location::city.state'),
                'attr' => [
                    'id' => 'state_id',
                    'data-url' => route('ajax.states-by-country'),
                    'class' => 'select-search-full',
                    'data-type' => 'state',
                ],
                'choices' => ($this->getModel()->state_id ?
                        [
                            0 => trans('plugins/location::city.select_state'),
                            $this->model->state->id => $this->model->state->name,
                        ]
                        :
                        [0 => trans('plugins/location::city.select_state')]) + $states,
            ])
            ->add('order', NumberField::class, SortOrderFieldOption::make()->toArray())
            ->add('is_default', OnOffField::class, IsDefaultFieldOption::make()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->add('image', MediaImageField::class)
            ->setBreakFieldPoint('status');
    }
}

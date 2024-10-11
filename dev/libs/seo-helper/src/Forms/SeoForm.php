<?php

namespace Dev\SeoHelper\Forms;

use Dev\Base\Forms\FieldOptions\MediaImageFieldOption;
use Dev\Base\Forms\FieldOptions\RadioFieldOption;
use Dev\Base\Forms\FieldOptions\TextareaFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\MediaImageField;
use Dev\Base\Forms\Fields\RadioField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;

class SeoForm extends FormAbstract
{
    public function setup(): void
    {
        $meta = $this->getModel();

        $this
            ->contentOnly()
            ->add(
                'seo_meta[seo_title]',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('libs/seo-helper::seo-helper.seo_title'))
                    ->placeholder(trans('libs/seo-helper::seo-helper.seo_title'))
                    ->maxLength(70)
                    ->allowOverLimit()
                    ->value(old('seo_meta.seo_title', $meta['seo_title']))
                    ->toArray()
            )
            ->add(
                'seo_meta[seo_description]',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(trans('libs/seo-helper::seo-helper.seo_description'))
                    ->placeholder(trans('libs/seo-helper::seo-helper.seo_description'))
                    ->rows(3)
                    ->maxLength(160)
                    ->allowOverLimit()
                    ->value(old('seo_meta.seo_description', $meta['seo_description']))
                    ->toArray()
            )
            ->add(
                'seo_meta_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(trans('libs/seo-helper::seo-helper.seo_image'))
                    ->value(old('seo_meta_image', $meta['seo_image']))
                    ->toArray(),
            )
            ->add(
                'seo_meta[index]',
                RadioField::class,
                RadioFieldOption::make()
                    ->label(trans('libs/seo-helper::seo-helper.index'))
                    ->selected(old('seo_meta.index', $meta['index']))
                    ->choices([
                        'index' => trans('libs/seo-helper::seo-helper.index'),
                        'noindex' => trans('libs/seo-helper::seo-helper.noindex'),
                    ])
                    ->toArray()
            );
    }
}

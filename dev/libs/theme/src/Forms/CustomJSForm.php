<?php

namespace Dev\Theme\Forms;

use Dev\Base\Forms\FieldOptions\CodeEditorFieldOption;
use Dev\Base\Forms\Fields\CodeEditorField;
use Dev\Base\Forms\FormAbstract;
use Dev\Theme\Http\Requests\CustomJsRequest;

class CustomJSForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->setUrl(route('theme.custom-js.post'))
            ->setValidatorClass(CustomJsRequest::class)
            ->setActionButtons(view('core/base::forms.partials.form-actions', ['onlySave' => true])->render())
            ->add(
                'custom_header_js',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('libs/theme::theme.custom_header_js'))
                    ->helperText(trans('libs/theme::theme.custom_header_js_placeholder'))
                    ->value(setting('custom_header_js'))
                    ->mode('javascript')
                    ->maxLength(2500)
                    ->toArray()
            )
            ->add(
                'custom_body_js',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('libs/theme::theme.custom_body_js'))
                    ->helperText(trans('libs/theme::theme.custom_body_js_placeholder'))
                    ->value(setting('custom_body_js'))
                    ->mode('javascript')
                    ->maxLength(2500)
                    ->toArray()
            )
            ->add(
                'custom_footer_js',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('libs/theme::theme.custom_footer_js'))
                    ->helperText(trans('libs/theme::theme.custom_footer_js_placeholder'))
                    ->value(setting('custom_footer_js'))
                    ->mode('javascript')
                    ->maxLength(2500)
                    ->toArray()
            );
    }
}

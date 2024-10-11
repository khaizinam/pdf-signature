<?php

namespace Dev\Theme\Forms;

use Dev\Base\Forms\FieldOptions\CodeEditorFieldOption;
use Dev\Base\Forms\Fields\CodeEditorField;
use Dev\Base\Forms\FormAbstract;
use Dev\Theme\Http\Requests\CustomHtmlRequest;

class CustomHTMLForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->setUrl(route('theme.custom-html.post'))
            ->setValidatorClass(CustomHtmlRequest::class)
            ->setActionButtons(view('core/base::forms.partials.form-actions', ['onlySave' => true])->render())
            ->add(
                'custom_header_html',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('libs/theme::theme.custom_header_html'))
                    ->helperText(trans('libs/theme::theme.custom_header_html_placeholder'))
                    ->value(setting('custom_header_html'))
                    ->mode('html')
                    ->maxLength(2500)
                    ->toArray()
            )
            ->add(
                'custom_body_html',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('libs/theme::theme.custom_body_html'))
                    ->helperText(trans('libs/theme::theme.custom_body_html_placeholder'))
                    ->value(setting('custom_body_html'))
                    ->mode('html')
                    ->maxLength(2500)
                    ->toArray()
            )
            ->add(
                'custom_footer_html',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('libs/theme::theme.custom_footer_html'))
                    ->helperText(trans('libs/theme::theme.custom_footer_html_placeholder'))
                    ->value(setting('custom_footer_html'))
                    ->mode('html')
                    ->maxLength(2500)
                    ->toArray()
            );
    }
}

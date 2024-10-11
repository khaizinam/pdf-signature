<?php

namespace Dev\Theme\Forms;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Forms\FieldOptions\CodeEditorFieldOption;
use Dev\Base\Forms\Fields\CodeEditorField;
use Dev\Base\Forms\FormAbstract;
use Dev\Theme\Facades\Theme;
use Dev\Theme\Http\Requests\CustomCssRequest;
use Illuminate\Support\Facades\File;

class CustomCSSForm extends FormAbstract
{
    public function setup(): void
    {
        $css = null;
        $file = Theme::getStyleIntegrationPath();

        if (File::exists($file)) {
            $css = BaseHelper::getFileData($file, false);
        }

        $this
            ->setUrl(route('theme.custom-css.post'))
            ->setValidatorClass(CustomCssRequest::class)
            ->setActionButtons(view('core/base::forms.partials.form-actions', ['onlySave' => true])->render())
            ->add(
                'custom_css',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('libs/theme::theme.custom_css'))
                    ->value($css)
                    ->mode('css')
                    ->toArray()
            );
    }
}

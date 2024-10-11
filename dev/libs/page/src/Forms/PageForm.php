<?php

namespace Dev\Page\Forms;

use Dev\Base\Forms\FieldOptions\ContentFieldOption;
use Dev\Base\Forms\FieldOptions\DescriptionFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\EditorField;
use Dev\Base\Forms\Fields\MediaImageField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Page\Http\Requests\PageRequest;
use Dev\Page\Models\Page;
use Dev\Page\Supports\Template;

class PageForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Page::class)
            ->setValidatorClass(PageRequest::class)
            ->hasTabs()
            ->add('name', TextField::class, NameFieldOption::make()->maxLength(120)->required()->toArray())
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('content', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->when(Template::getPageTemplates(), function (PageForm $form, array $templates) {
                return $form
                    ->add(
                        'template',
                        SelectField::class,
                        SelectFieldOption::make()
                            ->label(trans('core/base::forms.template'))
                            ->required()
                            ->choices($templates)
                            ->toArray()
                    );
            })
            ->add('image', MediaImageField::class)
            ->setBreakFieldPoint('status');
    }
}

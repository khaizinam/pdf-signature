<?php

namespace Dev\Comment\Forms\Fronts;

use Dev\Base\Forms\FieldOptions\EmailFieldOption;
use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\FieldOptions\TextareaFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\EmailField;
use Dev\Base\Forms\Fields\OnOffCheckboxField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Forms\FormBuilder;
use Dev\Base\Models\BaseModel;
use Dev\Captcha\Forms\Fields\ReCaptchaField;
use Dev\Theme\FormFront;
use Dev\Comment\Http\Requests\Fronts\CommentRequest;
use Dev\Comment\Support\CommentHelper;
use Illuminate\Support\Arr;

class CommentForm extends FormFront
{
    protected static ?BaseModel $reference = null;

    public function setup(): void
    {
        $preparedData = CommentHelper::preparedDataForFill();

        $this
            ->contentOnly()
            ->setFormOption('class', 'comment-form')
            ->setUrl(route('comment.public.comments.store'))
            ->setValidatorClass(CommentRequest::class)
            ->columns()
            ->when(
                $this->getReference(),
                function (FormAbstract $form, BaseModel $reference) {
                    $form
                        ->add('reference_id', 'hidden', ['value' => $reference->getKey()])
                        ->add('reference_type', 'hidden', ['value' => $reference::class]);
                },
                fn (FormAbstract $form) => $form->add('reference_url', 'hidden', ['value' => url()->current()])
            )
            ->add(
                'content',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(trans('plugins/comment::comment.common.comment'))
                    ->required()
                    ->colspan(2)
                    ->toArray()
            )
            ->add(
                'name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/comment::comment.common.name'))
                    ->when(
                        Arr::get($preparedData, 'name'),
                        fn (TextFieldOption $option, $value) => $option->defaultValue($value)->disabled(),
                        fn (TextFieldOption $option) => $option->required()
                    )
                    ->colspan(1)
                    ->toArray()
            )
            ->add(
                'email',
                EmailField::class,
                EmailFieldOption::make()->label(trans('plugins/comment::comment.common.email'))
                    ->when(
                        Arr::get($preparedData, 'email'),
                        fn (EmailFieldOption $option, $value) => $option->defaultValue($value)->disabled(),
                        fn (EmailFieldOption $option) => $option->required()
                    )
                    ->colspan(1)
                    ->toArray()
            )
            ->add(
                'website',
                TextField::class,
                TextFieldOption::make()->label(trans('plugins/comment::comment.common.website'))
                    ->colspan(2)
                    ->when(
                        Arr::get($preparedData, 'website'),
                        fn (TextFieldOption $option, $value) => $option->defaultValue($value)->disabled()
                    )
                    ->toArray()
            )
            ->when(
                CommentHelper::isEnableReCaptcha(),
                fn (FormAbstract $form) => $form->add('recaptcha', ReCaptchaField::class)
            )
            ->when(CommentHelper::isShowCommentCookieConsent(), function (FormAbstract $form) {
                $form->add(
                    'cookie_consent',
                    OnOffCheckboxField::class,
                    OnOffFieldOption::make()
                        ->label(trans('plugins/comment::comment.front.form.cookie_consent'))
                        ->colspan(2)
                        ->toArray()
                );
            })
            ->setFormEndKey('button')
            ->add('button', 'submit', [
                'label' => trans('plugins/comment::comment.front.form.submit'),
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
                'colspan' => 2,
            ]);
    }

    public static function createWithReference(BaseModel $model): FormAbstract
    {
        static::$reference = $model;

        return app(FormBuilder::class)->create(static::class);
    }

    public static function getReference(): ?BaseModel
    {
        return static::$reference;
    }
}

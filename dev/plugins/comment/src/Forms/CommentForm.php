<?php

namespace Dev\Comment\Forms;

use Dev\Base\Forms\FieldOptions\EditorFieldOption;
use Dev\Base\Forms\FieldOptions\EmailFieldOption;
use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\EditorField;
use Dev\Base\Forms\Fields\EmailField;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Comment\Enums\CommentStatus;
use Dev\Comment\Http\Requests\CommentRequest;
use Dev\Comment\Models\Comment;

class CommentForm extends FormAbstract
{
    public function setup(): void
    {
        $model = $this->getModel();

        $this
            ->model(Comment::class)
            ->setValidatorClass(CommentRequest::class)
            ->setBreakFieldPoint('status')
            ->add(
                'permalink',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content(view('plugins/comment::partials.permalink', compact('model')))
                    ->toArray()
            )
            ->add(
                'name',
                TextField::class,
                TextFieldOption::make()->label(trans('plugins/comment::comment.common.name'))->toArray()
            )
            ->add(
                'email',
                EmailField::class,
                EmailFieldOption::make()->label(trans('plugins/comment::comment.common.email'))->toArray()
            )
            ->add(
                'website',
                TextField::class,
                TextFieldOption::make()->label(trans('plugins/comment::comment.url'))->toArray()
            )
            ->add(
                'content',
                EditorField::class,
                EditorFieldOption::make()
                    ->label(trans('plugins/comment::comment.common.comment'))
                    ->rows(5)
                    ->addAttribute('without-buttons', true)
                    ->toArray()
            )
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make()->choices(CommentStatus::labels())->toArray()
            )
            ->add(
                'created_at',
                TextField::class,
                TextFieldOption::make()->label(trans('plugins/comment::comment.submitted_on'))->disabled()->toArray()
            );
    }
}

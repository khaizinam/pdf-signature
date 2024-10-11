<?php

namespace Dev\Comment\Forms;

use Dev\Base\Forms\FieldOptions\EditorFieldOption;
use Dev\Base\Forms\Fields\EditorField;
use Dev\Theme\FormFront;
use Dev\Comment\Http\Requests\ReplyCommentRequest;

class ReplyCommentForm extends FormFront
{
    public function setup(): void
    {
        $this
            ->contentOnly()
            ->setFormOption('id', 'reply-comment-form')
            ->setValidatorClass(ReplyCommentRequest::class)
            ->add(
                'content',
                EditorField::class,
                EditorFieldOption::make()
                    ->addAttribute('without-buttons', true)
                    ->toArray()
            );
    }
}

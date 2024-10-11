<?php

namespace Dev\Ticksify\Forms\Fronts;

use Dev\Base\Forms\FieldOptions\ButtonFieldOption;
use Dev\Base\Forms\FieldOptions\EditorFieldOption;
use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\EditorField;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Theme\Facades\Theme;
use Dev\Theme\FormFront;
use Dev\Ticksify\Models\Message;

class MessageForm extends FormFront
{
    public function setup(): void
    {
        if (! is_in_admin()) {
            Theme::asset()->add('ticksify', 'vendor/core/plugins/ticksify/css/front-ticksify.css');
            Theme::asset()
                ->container('footer')
                ->add('ticksify', 'vendor/core/plugins/ticksify/js/front-ticksify.js');
        }

        $this
            ->model(Message::class)
            ->contentOnly()
            ->when(is_in_admin(), function (MessageForm $form) {
                $form
                    ->add(
                        'content',
                        EditorField::class,
                        EditorFieldOption::make()
                            ->rows(2),
                    );
            }, function (MessageForm $form) {
                $form
                    ->add(
                        'trix-editor',
                        HtmlField::class,
                        HtmlFieldOption::make()
                            ->content('<trix-editor input="content"></trix-editor>')
                    )
                    ->add(
                        'content',
                        'hidden',
                        TextFieldOption::make()
                            ->addAttribute('id', 'content')
                    );
            })
            ->add(
                'submit',
                'submit',
                ButtonFieldOption::make()
                    ->cssClass('btn btn-primary mt-3')
                    ->label(__('Reply'))
            );
    }
}

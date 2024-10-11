<?php

namespace Dev\Ticksify\Forms;

use Dev\ACL\Models\User;
use Dev\Base\Facades\Html;
use Dev\Base\Forms\FieldOptions\EditorFieldOption;
use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\EditorField;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\FormAbstract;
use Dev\Ticksify\Http\Requests\MessageRequest;
use Dev\Ticksify\Models\Message;

class MessageForm extends FormAbstract
{
    public function setup(): void
    {
        /** @var Message $model */
        $model = $this->getModel();

        $this
            ->model(Message::class)
            ->setValidatorClass(MessageRequest::class)
            ->setBreakFieldPoint('status')
            ->add(
                'ticket_id',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->disabled()
                    ->label(trans('plugins/ticksify::ticksify.ticket'))
                    ->content(Html::link(route('ticksify.tickets.show', $model->ticket), $model->ticket->title, ['class' => 'd-block mb-3']))
            )
            ->add(
                'sender_id',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->disabled()
                    ->label(trans('plugins/ticksify::ticksify.user'))
                    ->content(function () use ($model) {
                        $route = match ($model->sender_type) {
                            User::class => 'users.profile.view',
                            default => 'account.edit',
                        };

                        return Html::link(route($route, $model->sender), $model->sender->name, ['class' => 'd-block mb-3']);
                    })
            )
            ->add(
                'content',
                EditorField::class,
                EditorFieldOption::make()
                    ->required()
                    ->maxLength(10000),
            )
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make(),
            );
    }
}

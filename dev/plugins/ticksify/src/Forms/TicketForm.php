<?php

namespace Dev\Ticksify\Forms;

use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\FieldOptions\TextareaFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Ticksify\Enums\TicketPriority;
use Dev\Ticksify\Enums\TicketStatus;
use Dev\Ticksify\Http\Requests\TicketRequest;
use Dev\Ticksify\Models\Ticket;

class TicketForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Ticket::class)
            ->contentOnly()
            ->setValidatorClass(TicketRequest::class)
            ->setFormOption('id', 'ticket-form')
            ->setUrl(route('ticksify.tickets.update', $this->getModel()))
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/ticksify::ticksify.title'))
            )
            ->add(
                'content',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(trans('plugins/ticksify::ticksify.content'))
                    ->rows(5)
            )
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make()
                    ->choices(TicketStatus::labels()),
            )
            ->add(
                'priority',
                SelectField::class,
                StatusFieldOption::make()
                    ->label(trans('plugins/ticksify::ticksify.priority'))
                    ->choices(TicketPriority::labels()),
            )
            ->add(
                'is_locked',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/ticksify::ticksify.locked'))
            )
            ->add(
                'is_resolved',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/ticksify::ticksify.resolved'))
            );
    }
}

<?php

namespace Dev\Ticksify\Http\Controllers\Fronts;

use Dev\Base\Http\Controllers\BaseController;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Theme\Facades\Theme;
use Dev\Ticksify\Enums\TicketStatus;
use Dev\Ticksify\Forms\Fronts\MessageForm;
use Dev\Ticksify\Forms\Fronts\TicketForm;
use Dev\Ticksify\Http\Requests\Fronts\TicketRequest;
use Dev\Ticksify\Models\Ticket;
use Dev\Ticksify\Support\Helper;

class TicketController extends BaseController
{
    public function index()
    {
        SeoHelper::setTitle(__('Tickets'));
        Theme::breadcrumb()->add(__('Tickets'), route('ticksify.public.tickets.index'));
        Theme::asset()->add('ticksify', 'vendor/core/plugins/ticksify/css/front-ticksify.css');

        $tickets = Helper::getAuthUser()
            ->tickets()
            ->paginate();

        $user = Helper::getAuthUser();

        $stats = Ticket::query()
            ->where('sender_type', $user::class)
            ->where('sender_id', $user->getKey())
            ->withStatistics()
            ->first();

        return Theme::scope(
            'ticksify.tickets.index',
            compact('tickets', 'stats'),
            'plugins/ticksify::themes.tickets.index'
        )->render();
    }

    public function show(string $ticket)
    {
        /** @var Ticket $ticket */
        $ticket = Helper::getAuthUser()
            ->tickets()
            ->findOrFail($ticket);

        $title = __('Ticket #:ticket - :title', [
            'ticket' => $ticket->getKey(),
            'title' => $ticket->title,
        ]);

        SeoHelper::setTitle($title);
        Theme::breadcrumb()
            ->add(__('Tickets'), route('ticksify.public.tickets.index'))
            ->add($title);

        $messages = $ticket->messages()
            ->wherePublished()
            ->with('sender')
            ->latest()
            ->paginate(10);

        $form = MessageForm::create()
            ->setUrl(route('ticksify.public.tickets.messages.store', $ticket));

        return Theme::scope(
            'ticksify.tickets.show',
            compact('ticket', 'messages', 'form'),
            'plugins/ticksify::themes.tickets.show'
        )->render();
    }

    public function create()
    {
        SeoHelper::setTitle(__('Create Ticket'));
        Theme::breadcrumb()
            ->add(__('Tickets'), route('ticksify.public.tickets.index'))
            ->add(__('Create Ticket'));
        Theme::asset()->add('ticksify', 'vendor/core/plugins/ticksify/css/front-ticksify.css');

        $form = TicketForm::create();

        return Theme::scope(
            'ticksify.tickets.create',
            compact('form'),
            'plugins/ticksify::themes.tickets.create'
        )->render();
    }

    public function store(TicketRequest $request)
    {
        $form = TicketForm::create()->setRequest($request)->onlyValidatedData();
        $form->saving(function (TicketForm $form) {
            $model = $form->getModel();
            $user = Helper::getAuthUser();

            $model->fill([
                ...$form->getRequestData(),
                'sender_type' => $user::class,
                'sender_id' => $user->getKey(),
                'status' => TicketStatus::OPEN,
            ]);

            $model->save();
        });

        return $this
            ->httpResponse()
            ->setNextRoute(
                'ticksify.public.tickets.show',
                $form->getModel()->getKey()
            )
            ->setMessage(__('Your ticket has been created successfully.'));
    }
}

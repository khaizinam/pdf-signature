<?php

namespace Dev\Ticksify\Http\Controllers;

use Dev\Base\Facades\Assets;
use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Ticksify\Forms\Fronts\MessageForm;
use Dev\Ticksify\Forms\TicketForm;
use Dev\Ticksify\Http\Requests\TicketRequest;
use Dev\Ticksify\Models\Ticket;
use Dev\Ticksify\Tables\TicketTable;

class TicketController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ticksify::ticksify.name'))
            ->add(
                trans('plugins/ticksify::ticksify.tickets.name'),
                route('ticksify.tickets.index')
            );
    }

    public function index(TicketTable $ticketTable)
    {
        $this->pageTitle(trans('plugins/ticksify::ticksify.tickets.name'));

        return $ticketTable->renderTable();
    }

    public function show(Ticket $ticket)
    {
        $this->pageTitle($ticket->title);

        Assets::addStylesDirectly('vendor/core/plugins/ticksify/css/ticksify.css');

        $messages = $ticket->messages()
            ->latest()
            ->with('sender')
            ->paginate();

        $ticketForm = TicketForm::createFromModel($ticket);
        $messageForm = MessageForm::create()
           ->setUrl(route('ticksify.tickets.messages.store', $ticket));

        return view(
            'plugins/ticksify::tickets.show',
            compact('ticket', 'messageForm', 'ticketForm', 'messages')
        );
    }

    public function update(Ticket $ticket, TicketRequest $request)
    {
        $form = TicketForm::createFromModel($ticket)
            ->setRequest($request)
            ->onlyValidatedData();

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('ticksify.tickets.index')
            ->setNextRoute(
                'ticksify.tickets.show',
                $form->getModel()->getKey()
            )
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Ticket $ticket)
    {
        return DeleteResourceAction::make($ticket);
    }
}

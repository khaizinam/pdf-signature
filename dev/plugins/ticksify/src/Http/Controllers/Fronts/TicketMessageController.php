<?php

namespace Dev\Ticksify\Http\Controllers\Fronts;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Ticksify\Actions\StoreTicketMessageAction;
use Dev\Ticksify\Http\Requests\Fronts\TicketMessageRequest;
use Dev\Ticksify\Models\Ticket;
use Dev\Ticksify\Support\Helper;

class TicketMessageController extends BaseController
{
    public function store(
        string $ticket,
        TicketMessageRequest $request,
        StoreTicketMessageAction $storeTicketMessageAction
    ) {
        /** @var Ticket $ticket */
        $ticket = Helper::getAuthUser()
            ->tickets()
            ->findOrFail($ticket);

        if ($ticket->is_locked) {
            return $this->httpResponse()
                ->setMessage(__('This ticket is locked.'))
                ->setNextRoute('ticksify.public.tickets.show', $ticket->getKey());
        }

        $storeTicketMessageAction(Helper::getAuthUser(), $ticket, $request);

        return $this
            ->httpResponse()
            ->setNextRoute('ticksify.public.tickets.show', $ticket->getKey())
            ->setMessage(__('Your message has been sent successfully.'));
    }
}

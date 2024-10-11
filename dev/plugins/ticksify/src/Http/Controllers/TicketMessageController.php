<?php

namespace Dev\Ticksify\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Ticksify\Actions\StoreTicketMessageAction;
use Dev\Ticksify\Http\Requests\Fronts\TicketMessageRequest;
use Dev\Ticksify\Models\Ticket;

class TicketMessageController extends BaseController
{
    public function store(
        Ticket $ticket,
        TicketMessageRequest $request,
        StoreTicketMessageAction $storeTicketMessageAction
    ) {
        $storeTicketMessageAction($request->user(), $ticket, $request);

        return $this
            ->httpResponse()
            ->setNextRoute('ticksify.tickets.show', $ticket->getKey())
            ->setMessage(__('Your message has been sent successfully.'));
    }
}

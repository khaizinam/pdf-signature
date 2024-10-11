<?php

namespace Dev\Ticksify\Actions;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Ticksify\Events\MessageCreated;
use Dev\Ticksify\Forms\Fronts\MessageForm;
use Dev\Ticksify\Http\Requests\Fronts\TicketMessageRequest;
use Dev\Ticksify\Models\Ticket;
use Illuminate\Contracts\Auth\Authenticatable;

class StoreTicketMessageAction
{
    public function __invoke(
        Authenticatable $actor,
        Ticket $ticket,
        TicketMessageRequest $request
    ): void {
        MessageForm::create()
            ->setRequest($request)
            ->onlyValidatedData()
            ->saving(function (MessageForm $form) use ($ticket, $actor) {
                $message = $ticket->messages()->create([
                    ...$form->getRequestData(),
                    'status' => BaseStatusEnum::PUBLISHED,
                    'sender_type' => $actor::class,
                    'sender_id' => $actor->getKey(),
                ]);

                MessageCreated::dispatch($message);
            });
    }
}

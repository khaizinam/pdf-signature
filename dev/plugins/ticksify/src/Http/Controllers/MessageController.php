<?php

namespace Dev\Ticksify\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Ticksify\Forms\MessageForm;
use Dev\Ticksify\Http\Requests\MessageRequest;
use Dev\Ticksify\Models\Message;
use Dev\Ticksify\Tables\MessageTable;

class MessageController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ticksify::ticksify.name'))
            ->add(
                trans('plugins/ticksify::ticksify.messages.name'),
                route('ticksify.messages.index')
            );
    }

    public function index(MessageTable $messageTable)
    {
        $this->pageTitle(trans('plugins/ticksify::ticksify.messages.name'));

        return $messageTable->renderTable();
    }

    public function edit(Message $message)
    {
        $this->pageTitle(trans('core/base::forms.edit'));

        return MessageForm::createFromModel($message)->renderForm();
    }

    public function update(Message $message, MessageRequest $request)
    {
        $form = MessageForm::createFromModel($message)->setRequest($request);
        $form->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousRoute('ticksify.messages.index')
            ->setNextRoute(
                'ticksify.messages.edit',
                $form->getModel()->getKey()
            )
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Message $message)
    {
        return DeleteResourceAction::make($message);
    }
}

<?php

declare(strict_types=1);

namespace Dev\EmailLog\Http\Controllers;

use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Base\Supports\Breadcrumb;
use Exception;
use Dev\EmailLog\Forms\EmailLogForm;
use Dev\EmailLog\Models\EmailLog;
use Dev\EmailLog\Providers\EmailLogServiceProvider;
use Dev\EmailLog\Tables\EmailLogTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailLogController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/email-log::email-log.name'), route('email-logs.index'));
    }

    public function index(EmailLogTable $emailLogTable): View|Response
    {
        $this->pageTitle(trans('plugins/email-log::email-log.name'));

        return $emailLogTable->renderTable();
    }

    public function edit(EmailLog $emailLog): View
    {
        $this->pageTitle(trans('plugins/email-log::email-log.viewing_email_log', ['name' => $emailLog->subject, 'id' => $emailLog->id]));

        $tabs = [
            'html_body' => trans('plugins/email-log::email-log.html_body'),
            'text_body' => trans('plugins/email-log::email-log.text_body'),
            'raw_body' => trans('plugins/email-log::email-log.raw_body'),
            'debug_info' => trans('plugins/email-log::email-log.debug_info'),
        ];

        $form = EmailLogForm::createFromModel($emailLog)->renderForm();

        return view('plugins/email-log::email-logs.show', compact('emailLog', 'tabs', 'form'));
    }

    public function destroy(EmailLog $emailLog, Request $request): BaseHttpResponse
    {
        try {
            $emailLog->delete();

            event(new DeletedContentEvent(EmailLogServiceProvider::MODULE_NAME, $request, $emailLog));

            return $this
                ->httpResponse()
                ->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $e) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($e->getMessage());
        }
    }
}

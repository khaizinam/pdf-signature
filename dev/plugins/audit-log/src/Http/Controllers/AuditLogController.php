<?php

namespace Dev\AuditLog\Http\Controllers;

use Dev\AuditLog\Models\AuditHistory;
use Dev\AuditLog\Tables\AuditLogTable;
use Dev\Base\Facades\Assets;
use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseSystemController;
use Illuminate\Http\Request;

class AuditLogController extends BaseSystemController
{
    public function getWidgetActivities(Request $request)
    {
        $limit = $request->integer('paginate', 10);
        $limit = $limit > 0 ? $limit : 10;

        $histories = AuditHistory::query()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate($limit);

        return $this
            ->httpResponse()
            ->setData(view('plugins/audit-log::widgets.activities', compact('histories', 'limit'))->render());
    }

    public function index(AuditLogTable $dataTable)
    {
        Assets::addScriptsDirectly('vendor/core/plugins/audit-log/js/audit-log.js');

        $this->pageTitle(trans('plugins/audit-log::history.name'));

        return $dataTable->renderTable();
    }

    public function destroy(AuditHistory $auditLog)
    {
        return DeleteResourceAction::make($auditLog);
    }

    public function deleteAll()
    {
        AuditHistory::query()->truncate();

        return $this
            ->httpResponse()
            ->withDeletedSuccessMessage();
    }
}

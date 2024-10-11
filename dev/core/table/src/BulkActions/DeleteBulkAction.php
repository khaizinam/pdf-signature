<?php

namespace Dev\Table\BulkActions;

use Dev\Base\Contracts\BaseModel;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Exceptions\DisabledInDemoModeException;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Table\Abstracts\TableBulkActionAbstract;
use Illuminate\Database\Eloquent\Model;

class DeleteBulkAction extends TableBulkActionAbstract
{
    public function __construct()
    {
        $this
            ->label(trans('core/table::table.delete'))
            ->confirmationModalButton(trans('core/table::table.delete'))
            ->beforeDispatch(function () {
                if (BaseHelper::hasDemoModeEnabled()) {
                    throw new DisabledInDemoModeException();
                }
            });
    }

    public function dispatch(BaseModel|Model $model, array $ids): BaseHttpResponse
    {
        $model->newQuery()->whereKey($ids)->each(function (BaseModel|Model $item) {
            $item->delete();

            DeletedContentEvent::dispatch($item::class, request(), $item);
        });

        return BaseHttpResponse::make()
            ->withDeletedSuccessMessage();
    }
}

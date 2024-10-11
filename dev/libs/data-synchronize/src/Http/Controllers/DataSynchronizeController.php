<?php

namespace Dev\DataSynchronize\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;

class DataSynchronizeController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('core/base::layouts.tools'));
    }

    public function index()
    {
        $this->pageTitle(trans('libs/data-synchronize::data-synchronize.tools.export_import_data'));

        return view('libs/data-synchronize::data-synchronize');
    }
}

<?php

namespace Dev\Setting\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Setting\Http\Controllers\Concerns\InteractsWithSettings;

abstract class SettingController extends BaseController
{
    use InteractsWithSettings;

    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('core/setting::setting.title'), route('settings.index'));
    }
}

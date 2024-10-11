<?php

namespace Dev\Base\Http\Controllers\Concerns;

use Dev\Base\Facades\Breadcrumb as BreadcrumbFacade;
use Dev\Base\Supports\Breadcrumb;

trait HasBreadcrumb
{
    protected string $breadcrumbGroup = 'admin';

    protected function breadcrumb(): Breadcrumb
    {
        $breadcrumb = BreadcrumbFacade::for($this->breadcrumbGroup);

        if ($this->breadcrumbGroup === 'admin') {
            $breadcrumb->add(trans('core/dashboard::dashboard.title'), route('dashboard.index'));
        }

        return $breadcrumb;
    }
}

<?php

namespace Dev\Base\Facades;

use Dev\Base\Supports\PageTitle as PageTitleSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void setSiteName(string $siteName)
 * @method static void setSeparator(string $separator)
 * @method static void setTitle(string $title)
 * @method static string|null getTitle(bool $withSiteName = true)
 *
 * @see \Dev\Base\Supports\PageTitle
 */
class PageTitle extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PageTitleSupport::class;
    }
}

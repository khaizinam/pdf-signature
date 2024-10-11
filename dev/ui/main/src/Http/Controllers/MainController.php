<?php

namespace Theme\Main\Http\Controllers;

use Dev\Base\Facades\BaseHelper;
use Dev\Media\Facades\AppMedia;
use Dev\Page\Models\Page;
use Dev\Page\Services\PageService;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Slug\Facades\SlugHelper;
use Dev\Theme\Events\RenderingHomePageEvent;
use Dev\Theme\Facades\Theme;
use Dev\Theme\Http\Controllers\PublicController;
use Illuminate\Support\Arr;

class MainController extends PublicController
{
    public function getIndex()
    {
        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            $homepageId = BaseHelper::getHomepageId();
            if ($homepageId) {
                $slug = SlugHelper::getSlug(null, SlugHelper::getPrefix(Page::class), Page::class, $homepageId);
                if ($slug) {
                    $data = (new PageService)->handleFrontRoutes($slug);
                    Theme::layout('default');
                    return Theme::scope('index', $data['data'])->render();
                }
            }
        }
        SeoHelper::setTitle(theme_option('seo_title'))
            ->setDescription(theme_option('seo_description'))
            ->openGraph()
            ->setTitle(@theme_option('seo_title'))
            ->setSiteName(@theme_option('site_title'))
            ->setUrl(route('public.index'))
            ->setImage(AppMedia::getImageUrl(theme_option('seo_og_image'), 'og'))
            ->addProperty('image:width', '1200')
            ->addProperty('image:height', '630');

        Theme::breadcrumb()->add(__('Home'), route('public.index'));

        event(RenderingHomePageEvent::class);
    }

    public function getView(?string $key = null, string $prefix = '')
    {
        return parent::getView($key);
    }

    public function getSiteMapIndex(string $key = null, string $extension = 'xml')
    {
        return parent::getSiteMapIndex();
    }
}

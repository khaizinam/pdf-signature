<?php

namespace Theme\Main\Http\Controllers;

use Dev\Base\Facades\BaseHelper;
use Dev\Media\Facades\AppMedia;
use Dev\Page\Models\Page;
use Dev\Page\Services\PageService;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Slug\Facades\SlugHelper;
use Dev\Theme\Events\RenderingHomePageEvent;
use Dev\Theme\Events\RenderingSingleEvent;
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
        if (empty($key)) {
            return $this->getIndex();
        }

        $slug = SlugHelper::getSlug($key, '');

        if (!$slug) {
            abort(404);
        }

        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            if ($slug->reference_type == Page::class && BaseHelper::isHomepage($slug->reference_id)) {
                return redirect()->to('/');
            }
        }

        $result = apply_filters(BASE_FILTER_PUBLIC_SINGLE_DATA, $slug);

        if (isset($result['slug']) && $result['slug'] !== $key) {
            return redirect()->route('public.single', $result['slug']);
        }

        $page = Arr::get($result, 'data.page');

        SeoHelper::setTitle(Arr::get($page,'name',''))
            ->setDescription(Arr::get($page,'description',''))
            ->openGraph()
            ->setTitle(Arr::get($page,'name',''))
            ->setSiteName(Arr::get($page,'name',''))
            ->setUrl(route('public.index',$key))
            ->setImage(get_object_image(Arr::get($page,'image','')))
            ->addProperty('image:width', '1200')
            ->addProperty('image:height', '630');

        event(new RenderingSingleEvent($slug));
        Theme::layout('default');

        if (!empty($result) && is_array($result)) {
            $view = Arr::get($result, 'data.page')->template ?? Arr::get($result, 'view', '');
            return Theme::scope($view, $result['data'], Arr::get($result, 'default_view'))->render();
        }
        abort(404);
        Theme::breadcrumb()->add(__('Trang chủ'), url("public.index"));
    }

    public function getSiteMapIndex(string $key = null, string $extension = 'xml')
    {
        return parent::getSiteMapIndex();
    }
}

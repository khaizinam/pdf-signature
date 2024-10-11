<?php

namespace Dev\Gallery\Providers;

use Dev\Base\Facades\AdminHelper;
use Dev\Base\Facades\Assets;
use Dev\Base\Facades\Html;
use Dev\Base\Facades\MetaBox;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Models\BaseModel;
use Dev\Base\Supports\ServiceProvider;
use Dev\Gallery\Facades\Gallery;
use Dev\Gallery\Models\Gallery as GalleryModel;
use Dev\Gallery\Services\GalleryService;
use Dev\Page\Models\Page;
use Dev\Page\Tables\PageTable;
use Dev\Shortcode\Compilers\Shortcode;
use Dev\Shortcode\Forms\ShortcodeForm;
use Dev\Slug\Models\Slug;
use Dev\Theme\Events\RenderingThemeOptionSettings;
use Dev\Theme\Facades\Theme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_action(BASE_ACTION_META_BOXES, [$this, 'addGalleryBox'], 13, 2);

        if (function_exists('shortcode')) {
            add_shortcode(
                'gallery',
                trans('plugins/gallery::gallery.gallery_images'),
                trans('plugins/gallery::gallery.add_gallery_short_code'),
                [$this, 'render']
            );

            shortcode()->setAdminConfig('gallery', function (array $attributes) {
                return ShortcodeForm::createFromArray($attributes)
                    ->withLazyLoading()
                    ->add('title', TextField::class, [
                        'label' => __('Title'),
                    ])
                    ->add('limit', NumberField::class, [
                        'label' => __('Limit'),
                    ]);
            });
        }

        add_filter(BASE_FILTER_PUBLIC_SINGLE_DATA, [$this, 'handleSingleView'], 11);

        PageTable::beforeRendering(function () {
            add_filter(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, [$this, 'addAdditionNameToPageName'], 147, 2);
        });

        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            add_filter(PAGE_FILTER_FRONT_PAGE_CONTENT, [$this, 'renderGalleriesPage'], 2, 2);
        }

        $this->app['events']->listen(RenderingThemeOptionSettings::class, function () {
            add_action(RENDERING_THEME_OPTIONS_PAGE, [$this, 'addThemeOptions'], 11);
        });
    }

    public function addGalleryBox(string $context, array|string|Model|null $object = null): void
    {
        if (
            AdminHelper::isInAdmin(true) &&
            $object instanceof BaseModel &&
            in_array($object::class, Gallery::getSupportedModules()) &&
            $context == 'advanced'
        ) {
            Assets::addStylesDirectly(['vendor/core/plugins/gallery/css/admin-gallery.css'])
                ->addScriptsDirectly(['vendor/core/plugins/gallery/js/gallery-admin.js'])
                ->addScripts(['sortable']);

            MetaBox::addMetaBox(
                'gallery_wrap',
                trans('plugins/gallery::gallery.gallery_box'),
                [$this, 'galleryMetaField'],
                $object::class,
                $context
            );
        }
    }

    public function galleryMetaField(): string
    {
        $value = null;
        $args = func_get_args();

        if ($args[0] && $args[0]->id) {
            $value = gallery_meta_data($args[0]);
        }

        return view('plugins/gallery::gallery-box', compact('value'))->render();
    }

    public function render(Shortcode $shortcode): string
    {
        $limit = (int) $shortcode->limit;

        $galleries = GalleryModel::query()
            ->with(['slugable', 'user'])
            ->wherePublished()
            ->when($limit > 0, fn ($query) => $query->limit($limit))
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->get();

        $view = apply_filters('galleries_box_template_view', 'plugins/gallery::shortcodes.gallery');

        return view($view, compact('shortcode', 'galleries'))->render();
    }

    public function handleSingleView(Slug|array $slug): Slug|array
    {
        return (new GalleryService())->handleFrontRoutes($slug);
    }

    public function renderGalleriesPage(?string $content, Page $page): ?string
    {
        if ($page->getKey() == theme_option('galleries_page_id')) {
            $view = 'plugins/gallery::themes.galleries';

            if (view()->exists($viewPath = Theme::getThemeNamespace() . '::views.galleries')) {
                $view = $viewPath;
            }

            return view($view, ['galleries' => get_galleries(-1)])->render();
        }

        return $content;
    }

    public function addAdditionNameToPageName(?string $name, Page $page): ?string
    {
        if ($page->getKey() == theme_option('galleries_page_id')) {
            $subTitle = Html::tag(
                'span',
                trans('plugins/gallery::gallery.galleries_page'),
                ['class' => 'additional-page-name']
            )
                ->toHtml();

            if (Str::contains($name, ' —')) {
                return $name . ', ' . $subTitle;
            }

            return $name . ' —' . $subTitle;
        }

        return $name;
    }

    public function addThemeOptions(): void
    {
        $pages = Page::query()->wherePublished()->pluck('name', 'id')->all();

        if (! empty($pages)) {
            theme_option()
                ->setField([
                    'id' => 'galleries_page_id',
                    'section_id' => 'opt-text-subsection-page',
                    'type' => 'customSelect',
                    'label' => trans('plugins/gallery::gallery.galleries_page'),
                    'attributes' => [
                        'name' => 'galleries_page_id',
                        'list' => ['' => trans('core/base::forms.select_placeholder')] + $pages,
                        'value' => '',
                        'options' => [
                            'class' => 'form-control',
                        ],
                    ],
                ]);
        }
    }
}

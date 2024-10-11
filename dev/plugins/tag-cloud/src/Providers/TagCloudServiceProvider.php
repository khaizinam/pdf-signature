<?php

namespace Dev\TagCloud\Providers;

use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\TagCloud\Widgets\TagCloud;
use Illuminate\Support\ServiceProvider;

class TagCloudServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/tag-cloud')
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadAndPublishViews();

        $this->app->booted(function () {
            register_widget(TagCloud::class);

            add_filter(THEME_FRONT_FOOTER, function (string|null $html) {
                return $html . view('plugins/tag-cloud::footer')->render();
            }, 155);
        });
    }
}

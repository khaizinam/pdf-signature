<?php

namespace Dev\VigReactions\Providers;

use Dev\Base\Models\BaseModel;
use Dev\VigReactions\Models\VigReactions;
use Dev\VigReactions\Models\VigReactionMeta;
use Illuminate\Support\ServiceProvider;
use Dev\VigReactions\Repositories\Caches\VigReactionsCacheDecorator;
use Dev\VigReactions\Repositories\Eloquent\VigReactionsRepository;
use Dev\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Dev\VigReactions\Repositories\Caches\VigReactionMetaCacheDecorator;
use Dev\VigReactions\Repositories\Eloquent\VigReactionMetaRepository;
use Dev\VigReactions\Repositories\Interfaces\VigReactionMetaInterface;
use Dev\Base\Supports\Helper;
use Event;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use MacroableModels;
use Dev\Slug\SlugHelper;

class VigReactionsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(VigReactionsInterface::class, function () {
            return new VigReactionsCacheDecorator(new VigReactionsRepository(new VigReactions));
        });

        $this->app->bind(VigReactionMetaInterface::class, function () {
            return new VigReactionMetaCacheDecorator(new VigReactionMetaRepository(new VigReactionMeta));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/vig-reactions')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        // config()->set('database.mysql.strict', false);

        foreach (array_keys($this->app->make(SlugHelper::class)->supportedModels()) as $item) {
            if (!class_exists($item)) {
                continue;
            }
            /**
             * @var BaseModel $item
             */
            $item::resolveRelationUsing('reactions', function ($model) {
                return $model->morphMany(VigReactions::class, 'reactable');
            });

            MacroableModels::addMacro($item, 'reactionSummary', function () {
                return $this->reactions->groupBy('type')->map(function ($val) {
                    return $val->count();
                });
            });

            MacroableModels::addMacro($item, 'reactionTotal', function () {
                return $this->reactions->count();
            });

            MacroableModels::addMacro($item, 'getReactionSummaryAttribute', function () {
                return $this->reactionSummary();
            });

            MacroableModels::addMacro($item, 'getSummaryAttribute', function () {
                return $this->reactionTotal();
            });
        }


        dashboard_menu()->registerItem([
            'id'          => 'cms-plugins-vig-reactions',
            'priority'    => 5,
            'parent_id'   => null,
            'name'        => 'Reaction Manager',
            'icon'        => 'fa fa-list',
            'url'         => route('vig-reactions.index'),
            'permissions' => ['vig-reactions.index'],
        ]);
    }
}

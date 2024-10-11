<?php

namespace Dev\ElasticsearchLaravel\Providers;

use Illuminate\Support\ServiceProvider;

use Dev\Base\Supports\Helper;
use Dev\Kernel\Traits\LoadAndPublishDataTrait;
use Dev\ElasticsearchLaravel\Services\ElasticsearchService;
use Dev\ElasticsearchLaravel\Facades\ElasticsearchLaravelFacade;
use Dev\ElasticsearchLaravel\Repositories\Eloquent\PostRepository;
use Dev\ElasticsearchLaravel\Repositories\Interfaces\PostInterface;
use Dev\Blog\Models\Post;

class ElasticsearchLaravelServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/es.php',
            'es'
        );

        $this->app->singleton("es-makeindex", function ($app) {
            $config = config('es');
            return new ElasticsearchService($config);
        });

        Helper::autoload(__DIR__ . '/../../helpers');

        /**
         * singleton or bind ?
         */
        // $this->app->bind(PostInterface::class, function () {
        //     return new PostRepository(new Post());
        // });
        $this->app->singleton(PostInterface::class, function ($app) {
            return new PostRepository(new Post());
        });

        // Override, can be?
        // $this->app->bind(\Dev\Member\Repositories\Interfaces\MemberInterface::class, function () {
        //     return new \Dev\Member\Repositories\Eloquent\MemberRepository(new \Dev\AdvancedRole\Models\Member());
        // });

        // Override controller!
        // $this->app->bind(\Dev\Api\Http\Controllers\AuthenticationController::class, \Dev\Auth\Http\Controllers\API\v1\AuthController::class);

    }

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->register(CommandServiceProvider::class);
        $this->setNamespace('libs/elasticsearch-laravel')
            ->loadAndPublishConfigurations(['es', 'general'])
            ->loadRoutes(['api'])
            ->loadMigrations();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            'es-makeindex'
        ];
    }
}

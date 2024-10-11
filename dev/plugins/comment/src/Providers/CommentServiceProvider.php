<?php

namespace Dev\Comment\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\Forms\FieldOptions\CheckboxFieldOption;
use Dev\Base\Forms\Fields\OnOffCheckboxField;
use Dev\Base\Models\BaseModel;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Blog\Forms\PostForm;
use Dev\PluginManagement\Events\DeactivatedPlugin;
use Dev\PluginManagement\Events\RemovedPlugin;
use Dev\Setting\PanelSections\SettingOthersPanelSection;
use Dev\Theme\FormFrontManager;
use Dev\Comment\Enums\CommentStatus;
use Dev\Comment\Forms\Fronts\CommentForm;
use Dev\Comment\Forms\ReplyCommentForm;
use Dev\Comment\Http\Requests\Fronts\CommentRequest;
use Dev\Comment\Http\Requests\Fronts\ReplyCommentRequest;
use Dev\Comment\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->instance('fob.comments.counter', []);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/comment')
            ->publishAssets()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadMigrations();

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-comment',
                    'priority' => 99,
                    'name' => 'plugins/comment::comment.title',
                    'icon' => 'ti ti-messages',
                    'route' => 'comment.comments.index',
                ]);
        });

        PanelSectionManager::default()->beforeRendering(function () {
            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('comment')
                    ->setTitle(trans('plugins/comment::comment.settings.title'))
                    ->withDescription(trans('plugins/comment::comment.settings.description'))
                    ->withIcon('ti ti-message-cog')
                    ->withPriority(0)
                    ->withRoute('comment.settings')
            );
        });

        $this->app->booted(function () {
            add_filter(BASE_FILTER_PUBLIC_COMMENT_AREA, function (string $html, BaseModel $model) {
                if ($model->getMetaData('allow_comments', true) == '0') {
                    return $html;
                }

                return $html . view('plugins/comment::comment', compact('model'))->render();
            }, 1, 2);

            add_filter(BASE_FILTER_APPEND_MENU_NAME, function (?string $html, string $menuId) {
                if ($menuId !== 'cms-plugins-comment') {
                    return $html;
                }

                return view('core/base::partials.navbar.badge-count', ['class' => 'unapproved-comments-count']);
            }, 1, 2);

            add_filter(BASE_FILTER_MENU_ITEMS_COUNT, function (array $data = []) {
                if (! Auth::guard()->user()->hasPermission('comment.comments.index')) {
                    return $data;
                }

                $data[] = [
                    'key' => 'unapproved-comments-count',
                    'value' => Comment::query()->where('status', CommentStatus::PENDING)->count(),
                ];

                return $data;
            }, 1, 2);

            if (is_plugin_active('blog')) {
                PostForm::extend(function (PostForm $form) {
                    $form->add(
                        'allow_comments',
                        OnOffCheckboxField::class,
                        CheckboxFieldOption::make()
                            ->label(trans('plugins/comment::comment.allow_comments'))
                            ->metadata()
                            ->defaultValue(true)
                            ->toArray()
                    );
                });
            }

            if (class_exists(FormFrontManager::class)) {
                FormFrontManager::register(CommentForm::class, CommentRequest::class);
                FormFrontManager::register(ReplyCommentForm::class, ReplyCommentRequest::class);
            }

            $this->app['events']->listen([DeactivatedPlugin::class, RemovedPlugin::class], function (DeactivatedPlugin|RemovedPlugin $event) {
                if ($event->plugin === 'member') {
                    Comment::query()->where('author_type', 'Dev\Member\Models\Member')->update([
                        'author_id' => null,
                        'author_type' => null,
                    ]);
                }
            });
        });
    }
}

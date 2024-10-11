<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Dev\Base\Supports\Database\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return false; // return if you dont want to use UUID instead of ID 







        Schema::disableForeignKeyConstraints();
        #region subcription plans
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('orders');
                dump($foreignKeys);

                $indexes = $this->listTableIndexes('orders');
                dump($indexes);
                // if (in_array('plans_slug_unique', $indexes)) $table->dropIndex('plans_slug_unique');

                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('orders', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('orders', 'plan_id')) {
                    $table->char('plan_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('orders', 'payment_id')) {
                    $table->char('payment_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('transactions');
                dump($foreignKeys);

                $indexes = $this->listTableIndexes('transactions');
                dump($indexes);
                // if (in_array('plans_slug_unique', $indexes)) $table->dropIndex('plans_slug_unique');

                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('transactions', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('transactions', 'payment_id')) {
                    $table->char('payment_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('transactions', 'reference_id')) {
                    $table->char('reference_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable(config('rinvex.subscriptions.tables.plans'))) {
            Schema::table(config('rinvex.subscriptions.tables.plans'), function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys(config('rinvex.subscriptions.tables.plans'));
                dump($foreignKeys);

                $indexes = $this->listTableIndexes(config('rinvex.subscriptions.tables.plans'));
                dump($indexes);
                // if (in_array('plans_slug_unique', $indexes)) $table->dropIndex('plans_slug_unique');

                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable(config('rinvex.subscriptions.tables.plan_features'))) {
            Schema::table(config('rinvex.subscriptions.tables.plan_features'), function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys(config('rinvex.subscriptions.tables.plan_features'));
                dump($foreignKeys);
                // if (in_array('plan_features_plan_id_foreign', $foreignKeys)) $table->dropForeign('plan_features_plan_id_foreign');

                $indexes = $this->listTableIndexes(config('rinvex.subscriptions.tables.plan_features'));
                dump($indexes);
                // if (in_array('plan_features_plan_id_slug_unique', $indexes)) $table->dropIndex('plan_features_plan_id_slug_unique');

                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn(config('rinvex.subscriptions.tables.plan_features'), 'plan_id')) {
                    $table->char('plan_id', 36)->nullable(true)->default(null)->change();
                }
            });
        }
        if (Schema::hasTable(config('rinvex.subscriptions.tables.plan_subscriptions'))) {
            Schema::table(config('rinvex.subscriptions.tables.plan_subscriptions'), function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys(config('rinvex.subscriptions.tables.plan_subscriptions'));
                dump($foreignKeys);
                // if (in_array('plan_subscriptions_plan_id_foreign', $foreignKeys)) $table->dropForeign('plan_subscriptions_plan_id_foreign');

                $indexes = $this->listTableIndexes(config('rinvex.subscriptions.tables.plan_subscriptions'));
                dump($indexes);
                // if (in_array('plan_subscriptions_slug_unique', $indexes)) $table->dropIndex('plan_subscriptions_slug_unique');
                // if (in_array('plan_subscriptions_subscriber_type_subscriber_id_index', $indexes)) $table->dropIndex('plan_subscriptions_subscriber_type_subscriber_id_index');
                // if (in_array('plan_subscriptions_plan_id_foreign', $indexes)) $table->dropIndex('plan_subscriptions_plan_id_foreign');

                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn(config('rinvex.subscriptions.tables.plan_subscriptions'), 'subscriber_id')) {
                    $table->char('subscriber_id', 36)->nullable(true)->default(null)->change();
                }
                if (Schema::hasColumn(config('rinvex.subscriptions.tables.plan_subscriptions'), 'plan_id')) {
                    $table->char('plan_id', 36)->nullable(true)->default(null)->change();
                }
            });
        }
        if (Schema::hasTable(config('rinvex.subscriptions.tables.plan_subscription_usage'))) {
            Schema::table(config('rinvex.subscriptions.tables.plan_subscription_usage'), function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys(config('rinvex.subscriptions.tables.plan_subscription_usage'));
                dump($foreignKeys);
                // if (in_array('plan_subscription_usage_feature_id_foreign', $foreignKeys)) $table->dropForeign('plan_subscription_usage_feature_id_foreign');
                // if (in_array('plan_subscription_usage_subscription_id_foreign', $foreignKeys)) $table->dropForeign('plan_subscription_usage_subscription_id_foreign');

                $indexes = $this->listTableIndexes(config('rinvex.subscriptions.tables.plan_subscription_usage'));
                dump($indexes);
                // if (in_array('plan_subscription_usage_feature_id_foreign', $indexes)) $table->dropIndex('plan_subscription_usage_feature_id_foreign');
                // if (in_array('plan_subscription_usage_subscription_id_feature_id_unique', $indexes)) $table->dropIndex('plan_subscription_usage_subscription_id_feature_id_unique');

                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn(config('rinvex.subscriptions.tables.plan_subscription_usage'), 'subscription_id')) {
                    $table->char('subscription_id', 36)->nullable(true)->default(null)->change();
                }
                if (Schema::hasColumn(config('rinvex.subscriptions.tables.plan_subscription_usage'), 'feature_id')) {
                    $table->char('feature_id', 36)->nullable(true)->default(null)->change();
                }
            });
        }
        #endregion

        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('payments', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->default(null)->change();
                }
            });
        }
        if (Schema::hasTable('url_redirector')) {
            Schema::table('url_redirector', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('activations')) {
            Schema::table('activations', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('activations', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('activity_log')) {
            Schema::table('activity_log', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('activity_log', 'causer_id')) {
                    $table->char('causer_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('activity_log', 'subject_id')) {
                    $table->char('subject_id', 36)->nullable(true)->change();
                }
            });
        }

        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('pages', 'user_id')) {
                    $table->char('user_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('pages_translations')) {
            Schema::table('pages_translations', function (Blueprint $table) {
                if (Schema::hasColumn('pages_translations', 'pages_id')) {
                    $table->char('pages_id', 36)->nullable(true)->change();
                }
            });
        }

        if (Schema::hasTable('posts')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('posts', 'author_id')) {
                    $table->char('author_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('posts_translations')) {
            Schema::table('posts_translations', function (Blueprint $table) {
                if (Schema::hasColumn('posts_translations', 'posts_id')) {
                    $table->char('posts_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('post_tags')) {
            Schema::table('post_tags', function (Blueprint $table) {
                // $table->uuid('id')->nullable(false)->change(); // no need to change w/ N-N
                if (Schema::hasColumn('post_tags', 'id')) {
                    $table->dropColumn('id'); // no need to change w/ N-N
                }
                if (Schema::hasColumn('post_tags', 'tag_id')) {
                    $table->char('tag_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('post_tags', 'post_id')) {
                    $table->char('post_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('tags')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('tags', 'author_id')) {
                    $table->char('author_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('tags_translations')) {
            Schema::table('tags_translations', function (Blueprint $table) {
                if (Schema::hasColumn('tags_translations', 'tags_id')) {
                    $table->char('tags_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('post_categories')) {
            Schema::table('post_categories', function (Blueprint $table) {
                // $table->uuid('id')->nullable(false)->change(); // no need to change w/ N-N
                if (Schema::hasColumn('post_categories', 'id')) {
                    $table->dropColumn('id'); // no need to change w/ N-N
                }
                if (Schema::hasColumn('post_categories', 'category_id')) {
                    $table->char('category_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('post_categories', 'post_id')) {
                    $table->char('post_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (Schema::hasColumn('categories', 'parent_id')) {
                    $table->char('parent_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('categories', 'author_id')) {
                    $table->char('author_id', 36)->nullable(true)->change();
                }

                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('categories_translations')) {
            Schema::table('categories_translations', function (Blueprint $table) {
                if (Schema::hasColumn('categories_translations', 'categories_id')) {
                    $table->char('categories_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('blocks')) {
            Schema::table('blocks', function (Blueprint $table) {
                if (Schema::hasColumn('blocks', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('countries')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('cities')) {
            Schema::table('cities', function (Blueprint $table) {
                if (Schema::hasColumn('cities', 'state_id')) {
                    $table->char('state_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('cities', 'country_id')) {
                    $table->char('country_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('cities', 'record_id')) {
                    $table->char('record_id', 36)->nullable(true)->change();
                }
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('contacts', 'contact_id')) {
                    $table->char('contact_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('contact_replies')) {
            Schema::table('contact_replies', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('contact_replies', 'contact_id')) {
                    $table->char('contact_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('custom_fields')) {
            Schema::table('custom_fields', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('custom_fields', 'use_for_id')) {
                    $table->char('use_for_id', 36)->nullable(false)->change();
                }
                if (Schema::hasColumn('custom_fields', 'field_item_id')) {
                    $table->char('field_item_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('custom_fields_translations')) {
            Schema::table('custom_fields_translations', function (Blueprint $table) {
                if (Schema::hasColumn('custom_fields_translations', 'custom_fields_id')) {
                    $table->char('custom_fields_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('dashboard_widgets')) {
            Schema::table('dashboard_widgets', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('dashboard_widget_settings')) {
            Schema::table('dashboard_widget_settings', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('dashboard_widget_settings', 'user_id')) {
                    $table->char('user_id', 36)->nullable(false)->change();
                }
                if (Schema::hasColumn('dashboard_widget_settings', 'widget_id')) {
                    $table->char('widget_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('field_groups')) {
            Schema::table('field_groups', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('field_groups', 'updated_by')) {
                    $table->char('updated_by', 36)->nullable(false)->change();
                }
                if (Schema::hasColumn('field_groups', 'created_by')) {
                    $table->char('created_by', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('field_items')) {
            Schema::table('field_items', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('field_items', 'field_group_id')) {
                    $table->char('field_group_id', 36)->nullable(false)->change();
                }
                if (Schema::hasColumn('field_items', 'parent_id')) {
                    $table->char('parent_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('galleries')) {
            Schema::table('galleries', function (Blueprint $table) {
                if (Schema::hasColumn('galleries', 'user_id')) {
                    $table->char('user_id', 36)->nullable(false)->change();
                }
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('gallery_meta')) {
            Schema::table('gallery_meta', function (Blueprint $table) {
                if (Schema::hasColumn('gallery_meta', 'reference_id')) {
                    $table->char('reference_id', 36)->nullable(false)->change();
                }
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('gallery_meta_translations')) {
            Schema::table('gallery_meta_translations', function (Blueprint $table) {
                if (Schema::hasColumn('gallery_meta_translations', 'gallery_meta_id')) {
                    $table->char('gallery_meta_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('galleries_translations')) {
            Schema::table('galleries_translations', function (Blueprint $table) {
                if (Schema::hasColumn('galleries_translations', 'galleries_id')) {
                    $table->char('galleries_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('gallery_meta')) {
            Schema::table('gallery_meta', function (Blueprint $table) {
                if (Schema::hasColumn('gallery_meta', 'reference_id')) {
                    $table->char('reference_id', 36)->nullable(true)->change();
                }
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('jobs')) {
            Schema::table('jobs', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('members', 'company_id')) {
                    $table->char('company_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('members', 'avatar_id')) {
                    $table->char('avatar_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('member_activity_logs')) {
            Schema::table('member_activity_logs', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('member_activity_logs', 'member_id')) {
                    $table->char('member_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('oauth_clients')) {
            Schema::table('oauth_clients', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('oauth_clients', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('oauth_auth_codes')) {
            Schema::table('oauth_auth_codes', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('oauth_auth_codes', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('oauth_auth_codes', 'client_id')) {
                    $table->char('client_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('oauth_access_tokens')) {
            Schema::table('oauth_access_tokens', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('oauth_access_tokens', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('oauth_access_tokens', 'client_id')) {
                    $table->char('client_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('oauth_personal_access_clients')) {
            Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('oauth_personal_access_clients', 'client_id')) {
                    $table->char('client_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('oauth_refresh_tokens')) {
            Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('oauth_refresh_tokens', 'access_token_id')) {
                    $table->char('access_token_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('personal_access_tokens')) {
            Schema::table('personal_access_tokens', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('personal_access_tokens', 'tokenable_id')) {
                    $table->char('tokenable_id', 36)->nullable(true)->change();
                }
            });
        }

        if (Schema::hasTable('admin_notifications')) {
            Schema::table('admin_notifications', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('menus')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('menu_nodes')) {
            Schema::table('menu_nodes', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('menu_nodes', 'menu_id')) {
                    $table->char('menu_id', 36)->nullable(false)->change();
                }
                if (Schema::hasColumn('menu_nodes', 'parent_id')) {
                    $table->char('parent_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('menu_nodes', 'reference_id')) {
                    $table->char('reference_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('menu_locations')) {
            Schema::table('menu_locations', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('menu_locations', 'menu_id')) {
                    $table->char('menu_id', 36)->nullable(false)->change();
                }
            });
        }

        if (Schema::hasTable('request_logs')) {
            Schema::table('request_logs', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('request_logs', 'user_id')) {
                    $table->string('user_id', 255)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('audit_histories')) {
            Schema::table('audit_histories', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('audit_histories', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('audit_histories', 'reference_id')) {
                    $table->char('reference_id', 36)->nullable(true)->change();
                }
                $table->char('reference_user', 36)->nullable(false)->change();
            });
        }
        if (Schema::hasTable('audits')) {
            Schema::table('audits', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('audits', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('audits', 'auditable_id')) {
                    $table->char('auditable_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('audits', 'reference_user')) {
                    $table->char('reference_user', 36)->nullable(false)->change();
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('users', 'avatar_id')) {
                    $table->char('avatar_id', 36)->nullable(true)->change();
                }
            });
        }
        if (Schema::hasTable('user_meta')) {
            Schema::table('user_meta', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('user_meta', 'user_id')) {
                    $table->char('user_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('roles', 'created_by')) {
                    $table->char('created_by', 36)->nullable(false)->change();
                }
                if (Schema::hasColumn('roles', 'updated_by')) {
                    $table->char('updated_by', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('role_users')) {
            Schema::table('role_users', function (Blueprint $table) {
                if (Schema::hasColumn('role_users', 'user_id')) {
                    $table->char('user_id', 36)->nullable(false)->change();
                }
                if (Schema::hasColumn('role_users', 'role_id')) {
                    $table->char('role_id', 36)->nullable(false)->change();
                }
            });
        }

        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('translations')) {
            Schema::table('translations', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('slugs')) {
            Schema::table('slugs', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('slugs', 'reference_id')) {
                    $table->char('reference_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('slugs_translations')) {
            Schema::table('slugs_translations', function (Blueprint $table) {
                if (Schema::hasColumn('slugs_translations', 'slugs_id')) {
                    $table->char('slugs_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('meta_boxes')) {
            Schema::table('meta_boxes', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('meta_boxes', 'reference_id')) {
                    $table->char('reference_id', 36)->nullable(false)->change();
                }
            });
        }
        if (Schema::hasTable('languages')) {
            Schema::table('languages', function (Blueprint $table) {
                $table->uuid('lang_id')->nullable(false)->change();
            });
        }
        if (Schema::hasTable('language_meta')) {
            Schema::table('language_meta', function (Blueprint $table) {
                $table->uuid('lang_meta_id')->nullable(false)->change();
                if (Schema::hasColumn('language_meta', 'reference_id')) {
                    $table->char('reference_id', 36)->nullable(false)->change();
                }
            });
        }

        if (Schema::hasTable('media_files')) {
            Schema::table('media_files', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('media_files', 'user_id')) {
                    $table->char('user_id', 36)->nullable(false)->change();
                }
                $table->char('folder_id', 36)->nullable(false)->change();
            });
        }
        if (Schema::hasTable('media_settings')) {
            Schema::table('media_settings', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('media_settings', 'user_id')) {
                    $table->char('user_id', 36)->nullable(false)->change();
                }
                $table->char('media_id', 36)->nullable(false)->change();
            });
        }
        if (Schema::hasTable('media_folders')) {
            Schema::table('media_folders', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('media_folders', 'user_id')) {
                    $table->char('user_id', 36)->nullable(false)->change();
                }
                $table->char('parent_id', 36)->nullable(true)->change();
            });
        }

        if (Schema::hasTable('revisions')) {
            Schema::table('revisions', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('revisions', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                $table->char('revisionable_id', 36)->nullable(false)->change();
            });
        }

        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->change();
                if (Schema::hasColumn('payments', 'order_id')) {
                    $table->char('order_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('payments', 'user_id')) {
                    $table->char('user_id', 36)->nullable(true)->change();
                }
                if (Schema::hasColumn('payments', 'customer_id')) {
                    $table->char('customer_id', 36)->nullable(true)->change();
                }
            });
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}

    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

    public function listTableIndexes($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableIndexes($table));
    }
};

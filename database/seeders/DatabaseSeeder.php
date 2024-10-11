<?php

namespace Database\Seeders;

use Dev\ACL\Database\Seeders\UserSeeder;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Supports\BaseSeeder;
use Dev\Block\Database\Seeders\StaticBlockSeeder;
use Dev\Contact\Database\Seeders\ContactSeeder;
use Dev\Language\Database\Seeders\LanguageSeeder;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->prepareRun();

        BaseHelper::maximumExecutionTimeAndMemoryLimit();

        $this->call(UserSeeder::class);

        $this->when(is_plugin_active('language'), fn () => $this->call(LanguageSeeder::class));

        $this->call(PageSeeder::class);

        $this->when(is_plugin_active('blog'), fn () => $this->call(BlogSeeder::class));
        $this->when(is_plugin_active('gallery'), fn () => $this->call(GallerySeeder::class));
        $this->when(is_plugin_active('member'), fn () => $this->call(MemberSeeder::class));
        $this->when(is_plugin_active('contact'), fn () => $this->call(ContactSeeder::class));
        $this->when(is_plugin_active('block'), fn () => $this->call(StaticBlockSeeder::class));
        $this->when(is_plugin_active('blog'), fn () => $this->call(MenuSeeder::class));

        $this->call([
            WidgetSeeder::class,
            ThemeOptionSeeder::class,
        ]);

        $this->finished();
    }
}

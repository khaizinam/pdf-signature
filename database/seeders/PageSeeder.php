<?php

namespace Database\Seeders;

use Dev\Base\Facades\Html;
use Dev\Base\Supports\BaseSeeder;
use Dev\Blog\Models\Category;
use Dev\CookieConsent\Database\Traits\HasCookieConsentSeeder;
use Dev\Page\Database\Traits\HasPageSeeder;

class PageSeeder extends BaseSeeder
{
    use HasPageSeeder;
    use HasCookieConsentSeeder;

    public function run(): void
    {
        $this->truncatePages();

        $pages = [
            [
                'name' => 'Homepage',
                'content' =>
                    Html::tag('div', '[featured-posts][/featured-posts]') .
                    Html::tag('div', '[recent-posts title="What\'s new?"][/recent-posts]') .
                    Html::tag('div', '[featured-categories-posts title="Best for you" category_id="' . Category::query()->skip(1)->value('id') . '" enable_lazy_loading="yes"][/featured-categories-posts]') .
                    Html::tag('div', '[all-galleries limit="8" title="Galleries" enable_lazy_loading="yes"][/all-galleries]')
                ,
                'template' => 'no-sidebar',
            ],
            [
                'name' => 'Blog',
                'content' => '---',
            ],
            [
                'name' => 'Contact',
                'content' => Html::tag(
                    'p',
                    'Address: North Link Building, 10 Admiralty Street, 757695 Singapore'
                ) .
                    Html::tag('p', 'Hotline: 18006268') .
                    Html::tag('p', 'Email: contact@fsofts.com') .
                    Html::tag(
                        'p',
                        '[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]'
                    ) .
                    Html::tag('p', 'For the fastest reply, please use the contact form below.') .
                    Html::tag('p', '[contact-form][/contact-form]'),
            ],
            [
                'name' => $this->getCookieConsentPageName(),
                'content' => $this->getCookieConsentPageContent(),
            ],
            [
                'name' => 'Galleries',
                'content' => '<div>[gallery title="Galleries" enable_lazy_loading="yes"][/gallery]</div>',
            ],
        ];

        $this->createPages($pages);
    }
}

<?php

namespace Dev\Ticksify\Seeders;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Supports\BaseSeeder;
use Dev\Ecommerce\Models\Customer;
use Dev\RealEstate\Models\Account;
use Dev\Ticksify\Enums\TicketPriority;
use Dev\Ticksify\Enums\TicketStatus;
use Dev\Ticksify\Models\Category;
use Dev\Ticksify\Models\Message;
use Dev\Ticksify\Models\Ticket;

class TicketSeeder extends BaseSeeder
{
    public function run(): void
    {
        Category::query()->truncate();
        Ticket::query()->truncate();
        Message::query()->truncate();

        $categories = [
            'Orders',
            'Technical Support',
            'FAQS',
            'Feedback',
            'Bug Report',
            'Feature Request',
            'Account and Login',
            'Payment and Billing',
            'Security and Privacy',
        ];

        $tickets = [
            'Issue with order processing',
            'Error in login functionality',
            'Feature request: Dark mode support',
            'Website performance degradation',
            'Unable to process payments',
            'Mobile app crashing on startup',
            'Password reset not working',
            'Missing email notifications',
            'Request for account deletion',
            'Security vulnerability report',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'status' => BaseStatusEnum::PUBLISHED,
            ]);
        }

        $faker = $this->fake();
        $categories = Category::query()->pluck('id');
        $userQuery = match (true) {
            is_plugin_active('ecommerce') => Customer::query(),
            is_plugin_active('real-estate') => Account::query(),
            is_plugin_active('job-board') => \Dev\JobBoard\Models\Account::query(),
            is_plugin_active('hotel') => \Dev\Hotel\Models\Account::query(),
        };
        $users = $userQuery->pluck('id');

        foreach ($tickets as $ticket) {
            Ticket::create([
                'category_id' => $categories->random(),
                'sender_type' => $userQuery->getModel()->getMorphClass(),
                'sender_id' => $users->random(),
                'title' => $ticket,
                'content' => $faker->paragraphs(3, true),
                'priority' => $faker->randomElement(TicketPriority::values()),
                'status' => $faker->randomElement(TicketStatus::values()),
                'is_locked' => $faker->boolean(10),
                'is_resolved' => $faker->boolean(20),
                'created_at' => $faker->dateTimeBetween('-1 month'),
            ]);
        }
    }
}

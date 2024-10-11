<?php

namespace Dev\Member\Listeners;

use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\Blog\Models\Post;
use Dev\Member\Models\Member;
use Dev\Member\Models\MemberActivityLog;
use Exception;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        try {
            $post = $event->data;

            if (! $post instanceof Post) {
                return;
            }

            if ($post->getKey() &&
                $post->author_type === Member::class &&
                auth('member')->check() &&
                $post->author_id == auth('member')->id()
            ) {
                MemberActivityLog::query()->create([
                    'action' => 'your_post_updated_by_admin',
                    'reference_name' => $post->name,
                    'reference_url' => route('public.member.posts.edit', $post->getKey()),
                ]);
            }
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}

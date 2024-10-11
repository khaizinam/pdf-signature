<?php

namespace Dev\Slug\Listeners;

use Dev\Base\Contracts\BaseModel;
use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\Slug\Facades\SlugHelper;
use Dev\Slug\Models\Slug;
use Dev\Slug\Services\SlugService;
use Exception;
use Illuminate\Support\Str;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event): void
    {
        if ($event->data instanceof BaseModel && SlugHelper::isSupportedModel($class = $event->data::class) && $event->request->input('is_slug_editable', 0)) {
            try {
                $slug = $event->request->input('slug');

                $fieldNameToGenerateSlug = SlugHelper::getColumnNameToGenerateSlug($event->data);

                if (! $slug) {
                    $slug = $event->request->input($fieldNameToGenerateSlug);
                }

                if (! $slug && $event->data->{$fieldNameToGenerateSlug}) {
                    if (! SlugHelper::turnOffAutomaticUrlTranslationIntoLatin()) {
                        $slug = Str::slug($event->data->{$fieldNameToGenerateSlug});
                    } else {
                        $slug = $event->data->{$fieldNameToGenerateSlug};
                    }
                }

                if (! $slug) {
                    $slug = time();
                }

                $slugService = new SlugService();

                Slug::query()->create([
                    'key' => $slugService->create($slug, (int) $event->data->slug_id, $class),
                    'reference_type' => $class,
                    'reference_id' => $event->data->getKey(),
                    'prefix' => SlugHelper::getPrefix($class, '', false),
                ]);
            } catch (Exception $exception) {
                BaseHelper::logError($exception);
            }
        }
    }
}

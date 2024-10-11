<?php

namespace Dev\Slug\Listeners;

use Dev\Base\Contracts\BaseModel;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Facades\BaseHelper;
use Dev\Slug\Events\UpdatedSlugEvent;
use Dev\Slug\Facades\SlugHelper;
use Dev\Slug\Models\Slug;
use Dev\Slug\Services\SlugService;
use Exception;
use Illuminate\Support\Str;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
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

                /**
                 * @var Slug $item
                 */
                $item = Slug::query()
                    ->where([
                        'reference_type' => $class,
                        'reference_id' => $event->data->getKey(),
                    ])
                    ->first();

                if ($item) {
                    if ($item->key != $slug) {
                        $slugService = new SlugService();
                        $item->key = $slugService->create($slug, (int) $event->data->slug_id);
                        $item->prefix = SlugHelper::getPrefix($class, '', false);
                        $item->save();
                    }
                } else {
                    /**
                     * @var Slug $item
                     */
                    $item = Slug::query()->create([
                        'key' => $slug,
                        'reference_type' => $class,
                        'reference_id' => $event->data->getKey(),
                        'prefix' => SlugHelper::getPrefix($class, '', false),
                    ]);
                }

                UpdatedSlugEvent::dispatch($event->data, $item);
            } catch (Exception $exception) {
                BaseHelper::logError($exception);
            }
        }
    }
}

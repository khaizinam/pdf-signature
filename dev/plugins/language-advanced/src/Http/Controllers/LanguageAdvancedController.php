<?php

namespace Dev\LanguageAdvanced\Http\Controllers;

use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Http\Controllers\BaseController;
use Dev\LanguageAdvanced\Http\Requests\LanguageAdvancedRequest;
use Dev\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Dev\Slug\Events\UpdatedSlugEvent;
use Dev\Slug\Facades\SlugHelper;
use Illuminate\Support\Facades\DB;

class LanguageAdvancedController extends BaseController
{
    public function save(int|string $id, LanguageAdvancedRequest $request)
    {
        $model = $request->input('model');

        if (! class_exists($model)) {
            abort(404);
        }

        $data = (new $model())->findOrFail($id);

        LanguageAdvancedManager::save($data, $request);

        $request->merge([
            'is_slug_editable' => 0,
        ]);

        do_action(LANGUAGE_ADVANCED_ACTION_SAVED, $data, $request);

        event(new UpdatedContentEvent('', $request, $data));

        $slugId = $request->input('slug_id');

        $language = $request->input('language');

        if ($slugId && $language) {
            $table = 'slugs_translations';

            $condition = [
                'lang_code' => $language,
                'slugs_id' => $slugId,
            ];

            $slugData = array_merge($condition, [
                'key' => $request->input('slug'),
                'prefix' => SlugHelper::getPrefix($model),
            ]);

            $translate = DB::table($table)->where($condition)->first();

            if ($translate) {
                DB::table($table)->where($condition)->update($slugData);
            } else {
                DB::table($table)->insert($slugData);
            }

            UpdatedSlugEvent::dispatch($data, $data->slugable);
        }

        $form = $request->input('form');

        if (class_exists($form) && is_subclass_of($form, FormAbstract::class)) {
            $form = $form::createFromModel($data);

            $form->saveMetadataFields();
        }

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage();
    }
}

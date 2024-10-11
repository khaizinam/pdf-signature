<?php

namespace Dev\Revision\Providers;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Forms\FormTab;
use Dev\Base\Models\BaseModel;
use Dev\Base\Supports\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        FormAbstract::extend(function (FormAbstract $form) {
            $model = $form->getModel();

            if (
                ! $model instanceof BaseModel
                || ! $model->exists
                || ! $this->isSupported($model)
            ) {
                return;
            }

            Assets::addStylesDirectly('vendor/core/libs/revision/css/revision.css')
                ->addScriptsDirectly([
                    'vendor/core/libs/revision/js/html-diff.js',
                    'vendor/core/libs/revision/js/revision.js',
                ]);

            $form->addTab(
                FormTab::make()
                    ->id('notes')
                    ->label(trans('core/base::tabs.revision'))
                    ->content(view('libs/revision::history-content', compact('model')))
            );
        }, 999);
    }

    protected function isSupported(string|Model $model): bool
    {
        if (is_object($model)) {
            $model = $model::class;
        }

        return in_array($model, config('libs.revision.general.supported', []));
    }
}

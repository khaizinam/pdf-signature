<?php

namespace Dev\Slug\Providers;

use Dev\Base\Facades\Form;
use Dev\Base\Supports\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            Form::component('permalink', 'libs/slug::permalink', [
                'name',
                'value' => null,
                'id' => null,
                'prefix' => '',
                'preview' => false,
                'attributes' => [],
                'editable' => true,
                'model' => '',
            ]);
        });
    }
}

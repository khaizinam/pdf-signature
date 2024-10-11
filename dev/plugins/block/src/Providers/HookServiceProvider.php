<?php

namespace Dev\Block\Providers;

use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Supports\ServiceProvider;
use Dev\Block\Models\Block;
use Dev\Shortcode\Compilers\Shortcode;
use Dev\Shortcode\Forms\ShortcodeForm;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! function_exists('shortcode')) {
            return;
        }

        add_shortcode(
            'static-block',
            trans('plugins/block::block.static_block_short_code_name'),
            trans('plugins/block::block.static_block_short_code_description'),
            [$this, 'render']
        );

        shortcode()->setPreviewImage(
            'static-block',
            asset('vendor/core/libs/shortcode/images/placeholder-code.jpg')
        );

        shortcode()->setAdminConfig('static-block', [$this, 'staticBlockAdminConfig']);
    }

    public function render(Shortcode $shortcode): ?string
    {
        $key = $shortcode->alias;

        if (! $key) {
            return null;
        }

        return Block::query()
            ->wherePublished()
            ->where('alias', $key)
            ->select(['id', 'content'])
            ->value('content');
    }

    public function staticBlockAdminConfig(array $attributes): FormAbstract
    {
        $blocks = Block::query()
            ->wherePublished()
            ->pluck('name', 'alias')
            ->all();

        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'alias',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/block::block.static_block_short_code_name'))
                    ->choices($blocks)
                    ->toArray()
            );
    }
}

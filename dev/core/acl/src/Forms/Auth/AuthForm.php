<?php

namespace Dev\ACL\Forms\Auth;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Models\BaseModel;

class AuthForm extends FormAbstract
{
    public function setup(): void
    {
        Assets::addScripts('form-validation')
            ->removeStyles([
                'select2',
                'fancybox',
                'spectrum',
                'custom-scrollbar',
                'datepicker',
                'fontawesome',
                'toastr',
            ])
            ->removeScripts([
                'select2',
                'fancybox',
                'cookie',
                'spectrum',
                'toastr',
                'modernizr',
                'excanvas',
                'jquery-waypoints',
                'stickytableheaders',
                'ie8-fix',
            ]);

        $this
            ->model(BaseModel::class)
            ->template('core/acl::auth.form');
    }

    public function heading(string $heading): self
    {
        $this->add(
            'heading',
            HtmlField::class,
            HtmlFieldOption::make()
                ->content(sprintf(
                    '<h2 class="h3 text-center mb-3">%s</h2>',
                    $heading
                ))
                ->toArray()
        );

        return $this;
    }

    public function submitButton(string $label, ?string $icon = null): self
    {
        $this
            ->add(
                'open_wrap_button',
                HtmlField::class,
                HtmlFieldOption::make()->content('<div class="form-footer">')->toArray()
            )
            ->add(
                'submit',
                HtmlField::class,
                HtmlFieldOption::make()->view('core/acl::auth.includes.submit', compact('label', 'icon'))->toArray()
            )
            ->add(
                'close_wrap_button',
                HtmlField::class,
                HtmlFieldOption::make()->content('</div>')->toArray()
            );

        return $this;
    }
}

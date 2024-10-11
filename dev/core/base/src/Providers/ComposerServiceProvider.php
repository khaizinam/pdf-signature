<?php

namespace Dev\Base\Providers;

use Dev\ACL\Models\User;
use Dev\Base\Supports\ServiceProvider;
use Dev\Media\Facades\AppMedia;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(Factory $view): void
    {
        $view->composer(['core/media::config'], function () {
            $mediaPermissions = AppMedia::getConfig('permissions', []);

            if (Auth::guard()->check()) {
                /**
                 * @var User $user
                 */
                $user = Auth::guard()->user();

                if (! $user->isSuperUser() && $user->permissions) {
                    $mediaPermissions = array_intersect(array_keys($user->permissions), $mediaPermissions);
                }
            }

            AppMedia::setPermissions($mediaPermissions);
        });
    }
}

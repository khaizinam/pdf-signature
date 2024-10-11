<?php

namespace Dev\Setting\Http\Requests;

use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;

class CacheSettingRequest extends Request
{
    public function rules(): array
    {
        $onOffRule = new OnOffRule();

        return [
            'enable_cache' => [$onOffRule],
            'cache_time' => ['nullable', 'required_if:enable_cache,1', 'integer', 'min:1'],
            'disable_cache_in_the_admin_panel' => [$onOffRule],
            'cache_admin_menu_enable' => [$onOffRule],
            'enable_cache_site_map' => [$onOffRule],
            'cache_front_menu_enabled' => [$onOffRule],
            'cache_user_avatar_enabled' => [$onOffRule],
            'cache_time_site_map' => ['nullable', 'required_if:enable_cache_site_map,1', 'integer', 'min:1'],
        ];
    }
}

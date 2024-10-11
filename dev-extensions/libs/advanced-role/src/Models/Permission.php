<?php

namespace Dev\AdvancedRole\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Config;
use Laratrust\Models\Permission as LaratrustPermission;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Facades\BaseHelper;

class Permission extends LaratrustPermission
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'reference_type',
        'allowed_scopes',
        'alias'
    ];

    protected $casts = [
        'alias' => 'json',
        'allowed_scopes' => 'json',
        'name' => SafeContent::class,
        'display_name' => SafeContent::class,
        'description' => SafeContent::class
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Config::get('laratrust.models.permission'),
            Config::get('laratrust.tables.permission_role'),
            Config::get('laratrust.foreign_keys.role'),
            Config::get('laratrust.foreign_keys.permission')
        )->withPivot('scope');
    }
}

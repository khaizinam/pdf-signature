<?php

namespace Dev\AdvancedRole\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Config;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Facades\BaseHelper;
use Dev\AdvancedRole\Traits\PermissionQueryBuilderScope;

use Laratrust\Models\Role as LaratrustRole;

class Role extends LaratrustRole
{
    use PermissionQueryBuilderScope;

    protected $table = 'app_roles';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'status'
    ];

    protected $casts = [
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
        )->withPivot(['scope']);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Role $role) {
            $role->permissions()->detach();
        });
    }
}

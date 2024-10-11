<?php

namespace Dev\AdvancedRole\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Facades\Html;
use Dev\Base\Models\BaseModel;
use Dev\AdvancedRole\Models\Team;
use Dev\AdvancedRole\Scopes\Interfaces\PermissionsBeforeQueryScope;
use Dev\AdvancedRole\Scopes\ActiveScope;
use Dev\AdvancedRole\Traits\PermissionQueryBuilderScope;
use Dev\AdvancedRole\Enums\ScopeEnum;

class Scope extends BaseModel implements PermissionsBeforeQueryScope
{
    use PermissionQueryBuilderScope;

    public static function boot()
    {
        parent::boot();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope()); // Applying Global Scopes, where is correct, booted or boot ????
    }

    protected $table = 'app_permission_scopes';

    public $guarded = [];

    /**
     * Global: cho phép truy cập toàn bộ records/ resource tất cả phòng ban; 
     * Deep: cho phép truy cập các records/ resource trong phòng ban trực thuộc và các phòng ban con của phòng ban đó; 
     * Local: chỉ cho phép truy cập các records/ resource trong phòng ban trực thuộc; 
     * Basic: chỉ cho phép truy cập các records/ resource đang được assign;None: không có quyền truy cập)
     * */

    protected $fillable = [
        'name', // it is scope's name, enum('none','basic','local','deep','global')
        'display_name',
        'description'
    ];

    protected $casts = [
        'name' => SafeContent::class,
        'display_name' => SafeContent::class,
        'description' => SafeContent::class
    ];

    /**
     * We have more Scopes such as: Global Scope (Anonymous Global Scope), Local Scope, Dynamic Scope
     * TODO: This is a Local Scope, implement scopeApplyPermissionsBeforeQuery() method.
     * 
     * @usage $scope = Scope::applyPermissionsBeforeQuery($query, $departmentIds, $scope)->orderBy('created_at')->get();
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApplyPermissionsBeforeQuery($query, $departmentIds, $scope = null)
    {
        // TODO: Implement scopeApplyPermissionsBeforeQuery() method.
        if (!blank($scope) && $scope == ScopeEnum::NONE) {
            $query->whereId(-1);
        }
        return $query;
    }

    /**
     * We have more Scopes such as: Global Scope (Anonymous Global Scope), Local Scope, Dynamic Scope
     * This is a Local Scope
     * 
     * @usage $scope = Scope::applyVisibility($query, $departmentIds, $scope)->orderBy('created_at')->get();
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApplyVisibility($query)
    {
        return $query;
    }
}

<?php

namespace Dev\AdvancedRole\Supports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;

use Dev\AdvancedRole\Models\Member;
use Dev\AdvancedRole\Enums\ScopeEnum;
use Dev\AdvancedRole\Models\Permission;
use Dev\AdvancedRole\Repositories\Interfaces\PermissionInterface;
use Dev\Patient\Models\Department;

class PermissionHelper
{
    /**
     * @param $entityName
     * @param $actionEntity
     * @return array|\Illuminate\Cache\CacheManager|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * TODO: Lấy ra danh sách phòng ban ứng với quyền người đó có, theo scope
     */
    public static function departmentsOfUser($entityName, $actionEntity)
    {
        $currentUser = auth()->user();
        $permission = self::queryPermission($entityName, $actionEntity);
        $departmentIds = [];

        $cacheKey = md5($entityName . $actionEntity . $permission->scope . $currentUser->id);

        if (cache()->has('department_ids_' . $cacheKey)) {
            $departmentIds = cache('department_ids_' . $cacheKey);
        } else {
            if (!blank($permission)) {
                switch ($permission->scope) {
                    case ScopeEnum::GLOBAL:
                        $departmentIds = Department::pluck('id')->toArray() ?? [];
                        break;

                    case ScopeEnum::DEEP:
                        $departmentIds = call_user_func_array('array_merge', $currentUser->departments->map(function ($dept) {
                            return $dept->getAllChildren()->pluck('id');
                        })->toArray());

                        break;

                    case ScopeEnum::LOCAL:
                        $departmentIds = $currentUser->departments->pluck('id')->toArray() ?? [];
                        break;

                    case ScopeEnum::BASIC:
                    default:
                        break;
                }
            }
            cache()->put('department_ids_' . $cacheKey, $departmentIds, config('libs.advanced-role.advanced-role.cache_time_second'));
        }

        return $departmentIds;
    }

    /**
     * @param $entityName
     * @param $actionEntity
     * @param null $resource
     * @return \Illuminate\Cache\CacheManager|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|mixed|object|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * TODO: Câu truy vấn lấy quyền tương ứng với tên của permission và class entity
     */
    public static function queryPermission($entityName, $actionEntity, $resource = null)
    {
        if (isset($resource) && !blank($resource)) {
            $currentUser = $resource;
        } else {
            $currentUser = auth()->user();
        }

        $objectRoles = $currentUser->objectRoles->pluck('role_id');
        $roles = $objectRoles->toArray() ?? [];

        $cacheKey = md5($entityName . $actionEntity . json_encode($objectRoles) . $currentUser->id);

        if (cache()->has('permission_by_entity_' . $cacheKey)) {
            $permission = cache('permission_by_entity_' . $cacheKey);
        } else {
            $permission = DB::table('app_permission_roles AS pr')
                ->select(DB::raw("pr.scope, app_permissions.name, app_permissions.entity, CASE
                WHEN pr.scope = '" . ScopeEnum::GLOBAL . "' THEN 1
                WHEN pr.scope = '" . ScopeEnum::DEEP . "' THEN 2
                WHEN pr.scope = '" . ScopeEnum::LOCAL . "' THEN 3
                WHEN pr.scope = '" . ScopeEnum::BASIC . "' THEN 4
                ELSE 5
            END AS priority"))
                ->join('app_permissions', 'pr.permission_id', '=', 'app_permissions.id')
                ->whereIn('role_id', $roles)
                ->where('reference_type', $entityName)
                ->where('name', $actionEntity)
                ->orderBy('priority')
                ->first();

            cache()->put('permission_by_entity_' . $cacheKey, $permission, config('libs.advanced-role.advanced-role.cache_time_second'));
        }

        return $permission;
    }

    /**
     * @param $resource
     * @param $actionEntity
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * TODO: Hàm để giúp xác định người dùng có quyền nào đó hay không
     */
    public static function canPermission($resource, $actionEntity)
    {
        $classNameEntity = is_null($resource) ? self::getEntityByAction($actionEntity) : self::getEntity($resource);

        if (!isset($resource->id) || blank($resource->id)) {
            $permission = self::queryPermission($classNameEntity, $actionEntity);
            if (blank($permission)) return false;

            return (bool)in_array($permission->scope, [
                ScopeEnum::GLOBAL,
                ScopeEnum::DEEP,
                ScopeEnum::LOCAL,
                ScopeEnum::BASIC
            ]);
        }

        switch ($classNameEntity) {
            case Member::class:
                $resourceScope = self::queryPermission($classNameEntity, $actionEntity, $resource);
                $currentUserScope = self::queryPermission($classNameEntity, $actionEntity);
                $scopeChecked = self::getPriorityOfScope($currentUserScope, $resourceScope);

                //TODO: Nếu người dùng chưa được thêm vào bất kì phòng ban nào thì sẽ trả về quyền user nào cũng được chỉnh sửa cả.
                if (blank($resource->departments)) {
                    return true;
                }

                //TODO: Nếu user đã được thêm vào một phòng ban thì sẽ kiểm tra xem scope của user hiện tại đang đăng nhập có được phép chỉnh sửa thông tin của resource hay không
                if ($scopeChecked) {
                    return (bool)app($classNameEntity)
                        ->when(in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(app($classNameEntity))), function ($q) {
                            $q->withTrashed();
                        })
                        ->applyPermissionsBeforeQuery(self::departmentsOfUser($classNameEntity, $actionEntity), self::queryPermission($classNameEntity, $actionEntity)->scope ?? null)
                        ->whereId($resource->id)
                        ->first() ?? false;
                }

                return false;

            default:
                $result = (bool)app($classNameEntity)
                    ->when(in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(app($classNameEntity))), function ($q) {
                        $q->withTrashed();
                    })
                    ->applyPermissionsBeforeQuery(self::departmentsOfUser($classNameEntity, $actionEntity), self::queryPermission($classNameEntity, $actionEntity)->scope ?? null)
                    ->whereId($resource->id)
                    ->first() ?? false;

                return $result;
        }
    }

    public static function getPriorityOfScope($currentUserScope, $resourceScope)
    {
        //TODO: Nếu $resourceScope == null (user chưa có role nào) thì sẽ so sánh $currentUserScope->piority với piority của role None mặc định = 5
        if (!isset($resourceScope->priority)) {
            if (isset($currentUserScope->priority) && $currentUserScope->priority < 5) {
                return true;
            }
            return false;
        }
        //TODO: Trường hợp tồn tại $resourceScope thì so sánh 2 piority của scope như bình thường
        if (isset($currentUserScope->priority) && isset($resourceScope->priority)) {
            return $resourceScope->priority >= $currentUserScope->priority;
        }
        return false;
    }

    public static function getEntity($resource)
    {
        return get_class($resource->getModel());
    }

    public static function getEntityByAction($action)
    {
        if (blank($action)) return null;

        return DB::table('app_permissions')->select('reference_type')
            ->where('name', $action)->first()->reference_type ?? null;
    }

    /**
     * Get permissions by User
     */
    public static function getPermissions($user)
    {
        if (blank($user)) return [];

        $objectRoles = $user->objectRoles->pluck('role_id');
        $roles = $objectRoles->toArray() ?? [];

        $cacheKey = md5(json_encode($objectRoles) . $user->id);

        if (cache()->has('permissions_' . $cacheKey)) {
            $results = cache('permissions_' . $cacheKey);
        } else {
            $permission = DB::table('app_permission_roles AS pr')
                ->select(DB::raw("app_permissions.name, MIN(CASE
                WHEN pr.scope = '" . ScopeEnum::GLOBAL . "' THEN 1
                WHEN pr.scope = '" . ScopeEnum::DEEP . "' THEN 2
                WHEN pr.scope = '" . ScopeEnum::LOCAL . "' THEN 3
                WHEN pr.scope = '" . ScopeEnum::BASIC . "' THEN 4
                ELSE 5
            END) AS priority"))
                ->join('app_permissions', 'pr.permission_id', '=', 'app_permissions.id')
                ->whereIn('role_id', $roles)
                ->where('pr.scope', '!=', 'None')
                ->groupBy('app_permissions.name')
                ->get();

            $results = array_map(function ($item) {
                return $item->name;
            }, $permission->toArray()) ?? [];

            cache()->put('permissions_' . $cacheKey, $results, config('libs.advanced-role.advanced-role.cache_time_second'));
        }

        return $results;
    }

    public static function getPermissionNameByAction($resource, $action)
    {
        $entityName = self::getEntity($resource);

        #region query from cache / database
        $cacheKey = md5(config('laratrust.tables.permissions', 'app_permissions')); // cache()->forget($cacheKey);
        if (cache()->has($cacheKey)) {
            $permissions = cache($cacheKey);
        } else {
            $permissions = app(PermissionInterface::class)->advancedGet([])->map(function ($item) {
                return new Fluent([
                    "id" => $item->id,
                    "name" => $item->name,
                    "display_name" => $item->display_name,
                    "description" => $item->description,
                    "reference_type" => $item->reference_type,
                    "allowed_scopes" => json_decode($item->allowed_scopes, true),
                    "alias" => json_decode($item->alias, true)
                ]);
            });
            $permissions = $permissions->toArray();
            cache()->put($cacheKey, $permissions, config('libs.advanced-role.advanced-role.cache_time_second')); // cache()->forever($cacheKey, $responseQuestions);
        }
        $permissionsConfig = array_values(
            array_filter($permissions, function ($permission) use ($entityName, $action) {
                return (bool) (
                    Arr::get(
                        $permission,
                        'reference_type',
                        null
                    ) === $entityName && in_array(
                        $action,
                        Arr::get(
                            $permission,
                            'alias',
                            null
                        )
                    )
                );
            })
        )[0] ?? null;

        return Arr::get(
            $permissionsConfig,
            'name',
            null
        );
        #endregion

        #region query from configuration file, temporary use only
        // $permissions = config('libs.advanced-role.permissions-seeds');
        // $permissionsConfig = array_values(
        //     array_filter(Arr::get(
        //         $permissions,
        //         'configs',
        //         []
        //     ), function ($permission) use ($entityName) {
        //         return (bool) isset($permission['entity']) && $permission['entity'] === $entityName;
        //     })
        // )[0] ?? null;

        // if (!blank($permissionsConfig) && isset($permissionsConfig['action'])) {
        //     $actionResource = array_filter($permissionsConfig['action'], function ($ac) use ($action) {
        //         return (bool)isset($ac['alias']) && in_array($action, $ac['alias']);
        //     });

        //     if (!blank($actionResource) && count($actionResource)) {
        //         $actionName = array_keys($actionResource)[0] ?? '';
        //         return $permissionsConfig['prefix'] . '.' . $actionName;
        //     }
        // }
        // return null;
        #endregion
    }
}

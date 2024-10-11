<?php

namespace Dev\AdvancedRole\Http\Middleware;

use Dev\AdvancedRole\Supports\PermissionHelper;
use Dev\Kernel\Exceptions\HandleResponseException;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * The middleware are registered automatically as "advanced-role"
 * 
 * Sẽ được sử dụng để phân quyền cao hơn thay cho các supports cơ bản của Laratrust 
 * 
 * Status: đang phát triển
 * 
 */
class AdvancedRoleMiddleware
{
    public $handleResponseException;

    public function __construct(HandleResponseException $handleResponseException)
    {
        $this->handleResponseException = $handleResponseException;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param null $action
     * @param null $parameter
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $action = null, $parameter = null)
    {
        $entityData = null;

        $entityName = PermissionHelper::getEntityByAction($action);

        if (blank($entityName)) {
            return $this->handleResponseException->canNotDoThisAction();
        }

        if (!blank($parameter)) {

            $dataParameter = request()->$parameter ?? request()->route($parameter);

            if (!blank($dataParameter) && $dataParameter instanceof Model) {
                $entityData = $dataParameter;
            } elseif (!blank($dataParameter)) {
                $entityData = app($entityName)
                    ->when(in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(app($entityName))), function ($q) {
                        $q->withTrashed();
                    })
                    ->find((int)$dataParameter);
            } else {
                return $this->handleResponseException->canNotDoThisAction();
            }

            if (blank($entityData)) {
                /*Nếu không có resource hiện đang trả ra lỗi 403. Thấy bất hợp lý nên mình sửa lại trả ra lỗi 404.*/
                /*return $this->handleResponseException->canNotDoThisAction();*/
                return $this->handleResponseException->dataNotFoundResponse();
            }
        }

        $canPermission = PermissionHelper::canPermission($entityData, $action);

        if (!$canPermission) {
            return $this->handleResponseException->canNotDoThisAction();
        }

        return $next($request);
    }
}

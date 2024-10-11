<?php

namespace Dev\AdvancedRole\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Dev\Base\Http\Responses\BaseHttpResponse;

use Dev\AdvancedRole\Http\Resources\RoleListResource;
use Dev\AdvancedRole\Http\Resources\RoleResource;
use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Repositories\Interfaces\PermissionInterface;
use Dev\AdvancedRole\Repositories\Interfaces\RoleInterface;
use Dev\AdvancedRole\Services\TeamService;
use Dev\AdvancedRole\Http\Requests\v1\StoreRoleRequest;

use Laratrust\Helper;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public RoleInterface $roleRepository;

    public PermissionInterface $permissionRepository;

    public TeamService $teamService;

    public function __construct(RoleInterface $roleRepository, TeamService $teamService, PermissionInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->teamService = $teamService;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request, BaseHttpResponse $response)
    {
        try {
            $rootTeam = $this->teamService->getRootTeam($request->user());
            $roles = $this->roleRepository->advancedGet([
                'order_by' => [
                    'created_at' => 'DESC'
                ]
            ]);

            return $response
                ->setData(RoleListResource::collection($roles));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreRoleRequest $request, BaseHttpResponse $response)
    {
        try {
            $role = $this->roleRepository->create(
                $request->only([
                    'name',
                    'display_name',
                    'description',
                ])
            );
            $permissions = $request->get('permissions', []);

            $this->syncPermissions($role, $permissions);

            return $response
                ->setData(new RoleResource($role))
                ->setMessage('Create successfully');
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    private function syncPermissions($role, $permissions)
    {
        $role->permissions()->sync([]);
        $mapPermissions = [];

        foreach ($permissions as $key => $permission) {
            // Get mysql permission ID
            $mapPermissions[Helper::getIdFor($permission['name'], 'permission')] = [
                'scope' => $permission['scope']
            ];
        }

        $role->permissions()->sync($mapPermissions);
        $role->flushCache();
    }

    public function show($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $role = $this->roleRepository->getFirstBy([
                'id' => $id
            ]);
            return $response
                ->setData(new RoleResource($role));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, StoreRoleRequest $request, BaseHttpResponse $response)
    {
        try {
            $role = $this->roleRepository->getFirstBy([
                'id' => $id
            ]);
            if (blank($role)) {
                return $response
                    ->setMessage(__('Data not found!'))
                    ->setCode(Response::HTTP_NO_CONTENT);
            }
            $role->fill([
                'display_name' => $request->get('name'),
            ]);
            $role->save();
            $this->syncPermissions($role, $request->get('permissions', []));
            return $response
                ->setData(new RoleResource($role))
                ->setMessage('Update successfully');
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $role = $this->roleRepository->getFirstBy([
                'id' => $id
            ]);

            if (blank($role)) {
                return $response
                    ->setMessage(__('Data not found!'))
                    ->setCode(Response::HTTP_NO_CONTENT);
            }

            $role->delete();

            return $response
                ->setMessage(__('Destroy successfully!'))
                ->setCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        try {
            $ids = $request->input('ids');
            if (empty($ids)) {
                return $response
                    ->setMessage(trans('core/base::notices.no_select'));
            }
            foreach ($ids as $id) {
                $usersAssignedToRole = DB::table(Config::get('laratrust.tables.role_user', 'app__role_members'))
                    ->where(Config::get('laratrust.foreign_keys.role'), $id)
                    ->count();

                $data = $this->roleRepository->getFirstBy([
                    'id' => $id,
                ]);
                if (!blank($data)) {
                    if (! Helper::roleIsDeletable($this->roleRepository)) {
                        return $response
                            ->setMessage(trans('The role is not deletable'));
                    }
                    if ($usersAssignedToRole > 0) {
                        return $response
                            ->setMessage(trans('Role is added to one or more users. It can not be deleted'));
                    } else {
                        $this->roleRepository->delete($data);
                    }
                }
            }

            return $response
                ->setMessage(__('Destroy successfully!'));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }
}

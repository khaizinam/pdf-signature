<?php

namespace Dev\AdvancedRole\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Dev\Base\Http\Responses\BaseHttpResponse;

use Dev\AdvancedRole\Http\Resources\PermissionResource;
use Dev\AdvancedRole\Http\Resources\PermissionListResource;
use Dev\AdvancedRole\Supports\PermissionHelper;
use Dev\AdvancedRole\Models\Permission;
use Dev\AdvancedRole\Repositories\Interfaces\PermissionInterface;
use Dev\AdvancedRole\Http\Requests\v1\StorePermissionRequest;

use Laratrust\Helper;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public PermissionInterface $permissionRepository;

    public function __construct(PermissionInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request, BaseHttpResponse $response)
    {
        try {
            $permissions = $this->permissionRepository->advancedGet([
                'select' => ['id', 'name', 'display_name', 'description', 'allowed_scopes', 'alias', 'created_at', 'updated_at']
            ]);
            return $response
                ->setData(PermissionListResource::collection($permissions));

            return $response
                ->setData($permissions);
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id, BaseHttpResponse $response)
    {
        try {
            $permission = $this->permissionRepository->getFirstBy([
                'id' => $id
            ]);
            return $response
                ->setData(new PermissionResource($permission));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(StorePermissionRequest $request, BaseHttpResponse $response)
    {
        try {
            $request->merge([
                'display_name' => $request->get('display_name'),
                'name' => $request->get('name')
            ]);

            $permission = $this->permissionRepository->create(
                $request->only([
                    'name',
                    'display_name',
                    'description',
                    'reference_type'
                ])
            );

            return $response
                ->setData(new PermissionResource($permission))
                ->setMessage('Create successfully');
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, StorePermissionRequest $request, BaseHttpResponse $response)
    {
        try {
            $permission = $this->permissionRepository->getFirstBy([
                'id' => $id
            ]);
            if (blank($permission)) {
                return $response
                    ->setMessage(__('Data not found!'))
                    ->setCode(Response::HTTP_NO_CONTENT);
            }
            $permission->fill([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'display_name' => $request->get('display_name'),
            ]);
            $permission->save();

            return $response
                ->setData(new PermissionResource($permission))
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
            $permission = $this->permissionRepository->getFirstBy([
                'id' => $id
            ]);

            if (blank($permission)) {
                return $response
                    ->setMessage(__('Data not found!'))
                    ->setCode(Response::HTTP_NO_CONTENT);
            }

            $permission->delete();

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
}

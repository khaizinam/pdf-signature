<?php

namespace Dev\AdvancedRole\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\AdvancedRole\Http\Requests\v1\StoreScopeRequest;
use Dev\AdvancedRole\Http\Requests\v1\UpdateScopeRequest;
use Dev\AdvancedRole\Http\Resources\ScopeListResource;
use Dev\AdvancedRole\Repositories\Interfaces\ScopeInterface;
use Dev\AdvancedRole\Http\Resources\ScopeResource;
use Dev\AdvancedRole\Supports\PermissionHelper;
use Dev\AdvancedRole\Facades\AdvancedRoleHelper;
use Dev\AdvancedRole\Models\Scope;
use Dev\Auth\Facades\AuthHelper;

class ScopeController extends BaseController
{
    public ScopeInterface $scopeRepository;

    public function __construct(ScopeInterface $scopeRepository)
    {
        $this->scopeRepository = $scopeRepository;

        // TODO The middleware are registered automatically as role, permission and ability: https://laratrust.santigarcor.me/docs/8.x/usage/middleware.html#concepts
        $this->middleware(
            "permission:" .
                PermissionHelper::getPermissionNameByAction($this->scopeRepository, 'index')
        )->only(['index']);

        $this->middleware(
            "permission:" .
                PermissionHelper::getPermissionNameByAction($this->scopeRepository, 'store')
        )->only(['store']);
        $this->middleware(
            "permission:" .
                PermissionHelper::getPermissionNameByAction($this->scopeRepository, 'edit')
        )->only(['edit', 'update']);
        $this->middleware(
            "permission:" .
                PermissionHelper::getPermissionNameByAction($this->scopeRepository, 'remove')
        )->only(['destroy', 'restore', 'forceDelete']);
    }

    public function index(Request $request, BaseHttpResponse $response, ScopeInterface $scopeRepository)
    {
        try {
            $scopes = $this->scopeRepository->advancedGet([
                'order_by' => [
                    'created_at' => 'ASC'
                ]
            ]);

            return $response
                ->setData(ScopeListResource::collection($scopes));
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
            $scope = $this->scopeRepository->getFirstBy([
                'id' => $id
            ]);
            return $response
                ->setData(new ScopeResource($scope));
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreScopeRequest $request, BaseHttpResponse $response)
    {
        try {
            $scope = $this->scopeRepository->create($request->only([
                'name', // it is scope's name
                'display_name',
                'description'
            ]));

            return $response
                ->setData(new ScopeResource($scope))
                ->setMessage('Create successfully');
        } catch (\Throwable $th) {
            return $response
                ->setError(true)
                ->setMessage($th->getMessage())
                ->setCode(Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, UpdateScopeRequest $request, BaseHttpResponse $response)
    {
        try {
            $scope = $this->scopeRepository->getFirstBy([
                'id' => $id
            ]);
            if (blank($scope)) {
                return $response
                    ->setMessage(__('Data not found!'))
                    ->setCode(Response::HTTP_NO_CONTENT);
            }
            $scope->fill([
                'display_name' => $request->get('display_name'),
                'description' => $request->get('description')
            ]);
            $scope->save();

            return $response
                ->setData(new ScopeResource($scope))
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
            $scope = $this->scopeRepository->getFirstBy([
                'id' => $id
            ]);

            if (blank($scope)) {
                return $response
                    ->setMessage(__('Data not found!'))
                    ->setCode(Response::HTTP_NO_CONTENT);
            }

            $scope->delete();

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

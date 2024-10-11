<?php

namespace Dev\AdvancedRole\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\AdvancedRole\Http\Requests\v1\StoreScopeRequest;
use Dev\AdvancedRole\Http\Requests\v1\UpdateScopeRequest;
use Dev\AdvancedRole\Http\Resources\ScopeListResource;
use Dev\AdvancedRole\Repositories\Interfaces\ScopeInterface;
use Dev\AdvancedRole\Http\Resources\ScopeResource;
use Dev\AdvancedRole\Supports\PermissionHelper;
use Dev\AdvancedRole\Models\Scope;
use Dev\AdvancedRole\Models\Member;
use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Permission;
use Dev\AdvancedRole\Models\PermissionRole;
use Dev\AdvancedRole\Models\PersonalAccessToken;
use Dev\AdvancedRole\Models\Team;

class TestController extends Controller
{
    public ScopeInterface $scopeRepository;

    public function __construct(ScopeInterface $scopeRepository)
    {
        $this->scopeRepository = $scopeRepository;
    }

    public function index(Request $request, BaseHttpResponse $response, ScopeInterface $scopeRepository)
    {
        try {
            $role = Role::where('id', 1)->first();
            $permission = Permission::where('name', 'products.index')->first();
            $member = $request->user();

            $role->syncPermissions([$permission]); // Role Permissions Assignment

            $member->addRole($role); // User Roles Assignment
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}

<?php

namespace Dev\AdvancedRole\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Dev\AdvancedRole\Http\Resources\RoleListResource;
use Dev\AdvancedRole\Http\Resources\RoleResource;
use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Repositories\Interfaces\PermissionInterface;
use Dev\AdvancedRole\Repositories\Interfaces\RoleInterface;
use Dev\AdvancedRole\Services\TeamService;
use Dev\AdvancedRole\Http\Requests\v1\StoreRoleRequest;
use Dev\AdvancedRole\Models\Member;

class RoleSeeder extends Seeder
{
    public RoleInterface $roleRepository;

    public PermissionInterface $permissionRepository;

    public TeamService $teamService;

    public function __construct(
        RoleInterface $roleRepository,
        TeamService $teamService,
        PermissionInterface $permissionRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->teamService = $teamService;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        if (config('libs.advanced-role.laratrust_seeder.truncate_tables')) {
            $this->command->info('Truncating Roles tables');
            Role::truncate();
        }

        $roles = [
            [
                'display_name' => 'Super Admin',
                'name' => 'super-admin',
                'description' => 'Super Admin: nhóm quyền hệ thống'
            ],
            [
                'display_name' => 'Reader',
                'name' => 'reader',
                'description' => 'Reader: nhóm quyền chỉ xem/đọc dữ liệu'
            ],
            [
                'display_name' => 'Member',
                'name' => 'member',
                'description' => 'Member: nhóm quyền được xem/đọc, +plus'
            ]
        ];

        foreach ($roles as $key => $role) {
            $this->command->info("Creating Role {$role['name']}");
            $role = Role::updateOrCreate([
                'name' => Str::slug($role['name']),
            ], [
                'name' => Str::slug($role['name']),
                'display_name' => $role['display_name'],
                'description' => $role['description']
            ]);

            if (config('libs.advanced-role.laratrust_seeder.create_users')) {
                $this->command->info("Creating '{$role['name']}' user");
                // Create default user for each role and add permission to the role
                $user = Member::updateOrCreate([
                    'email' => Str::slug($role['name']) . '@fsofts.com',
                ], [
                    'first_name' => ucwords(str_replace('_', ' ', $role['name'])),
                    'last_name' => ucwords(str_replace('_', ' ', $role['name'])),
                    'email' => Str::slug($role['name']) . '@fsofts.com',
                    'password' => bcrypt('password'),
                    'status' => 'published'
                ]);
                $user->addRole($role);
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}

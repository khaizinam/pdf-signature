<?php

namespace Dev\AdvancedRole\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Dev\AdvancedRole\Enums\ScopeEnum;
use Dev\AdvancedRole\Models\Member;
use Dev\AdvancedRole\Models\Permission;
use Dev\AdvancedRole\Models\PermissionMember;
use Dev\AdvancedRole\Models\PermissionRole;
use Dev\AdvancedRole\Models\RoleMember;
use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Team;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        if (config('libs.advanced-role.laratrust_seeder.truncate_tables')) {
            $this->command->info('Truncating Permissions tables');
            Permission::truncate();
            Team::truncate();
            PermissionRole::truncate();
            PermissionMember::truncate();
        }

        // Artisan::call('db:seed --class=\\Dev\\AdvancedRole\\Seeders\\ScopeSeeder'); // why can not call?
        // Artisan::call('db:seed --class=\\Dev\\AdvancedRole\\Seeders\\RoleSeeder'); // why can not call?

        $roles = Role::all();
        $members = Member::all();

        $permissionSeeder = config('libs.advanced-role.permissions-seeds');
        if (blank($permissionSeeder) || $permissionSeeder === null) {
            $this->command->error("The configuration has not been published. Did you run `php artisan vendor:publish --tag=\"laratrust-seeder\"`");
            $this->command->line('');
            return false;
        }

        foreach (
            Arr::get(
                $permissionSeeder,
                'configs',
                []
            ) as $variable
        ) {
            foreach (
                Arr::get(
                    $variable,
                    'action',
                    []
                ) as $key => $action
            ) {
                $this->command->info("Creating Permission to {$variable['prefix']}.{$key} for {$variable['entity']}");

                #region create permission
                $permission = Permission::updateOrCreate([
                    'name' => "{$variable['prefix']}.{$key}",
                ], [
                    'name' => "{$variable['prefix']}.{$key}",
                    'display_name' => $action['display_name'],
                    'description' => $action['display_name'],
                    'reference_type' => $variable['entity'],
                    'allowed_scopes' => apps_json_store('{}', Arr::get(
                        $action,
                        'allowed_scopes',
                        []
                    )),
                    'alias' => apps_json_store('{}', Arr::get(
                        $action,
                        'alias',
                        []
                    ))
                ]);
                #endregion

                #region add permission to the role
                foreach ($roles as $role) {
                    if ($permission) {
                        $permissionExists = DB::table(
                            config(
                                'laratrust.tables.permission_role',
                                'app__permission_roles'
                            )
                        )
                            ->where('permission_id', $permission->id)
                            ->where('role_id', $role->id)
                            ->first();

                        if (!$permissionExists) {
                            // Add permission to the role
                            $this->command->info("Add permission to the role {$role->name}");
                            $role->permissions()->attach($permission->id, [
                                'scope' => ScopeEnum::NONE,
                                'created_at' => now(config('app.timezone')),
                                'updated_at' => now(config('app.timezone'))
                            ]);
                        }
                    }
                }
                #endregion

                #region add permission to the user
                foreach ($members as $member) {
                    #region create default team and add permission to the member
                    // $teamName = $member->name . "'s Team";
                    // $team = Team::updateOrCreate([
                    //     'name' => Str::slug($teamName),
                    // ], [
                    //     'name' => Str::slug($teamName),
                    //     'display_name' => "{$teamName}",
                    //     'description' => "{$teamName}",
                    //     "parent_id" => null,
                    //     'author_id' => $member->id,
                    //     'author_type' => Member::class
                    // ]);
                    // if ($team && $permission) {
                    //     $permissionExists = DB::table(
                    //         config(
                    //             'laratrust.tables.permission_user',
                    //             'app__permission_members'
                    //         )
                    //     )
                    //         ->where('permission_id', $permission->id)
                    //         ->where('team_id', $member->id)
                    //         ->first();

                    //     if (!$permissionExists) {
                    //         // Add permission to the member
                    //         $this->command->info("Add permission to the team {$team->name}");
                    //         $member->givePermissions([$permission], $team);
                    //     }
                    // }
                    #endregion
                    
                    if ($permission) {
                        $permissionExists = DB::table(
                            config(
                                'laratrust.tables.permission_user',
                                'app__permission_members'
                            )
                        )
                            ->where('permission_id', $permission->id)
                            ->where('member_id', $member->id)
                            ->first();

                        if (!$permissionExists) {
                            // Add permission to the member
                            $this->command->info("Add permission to the member {$member->name}");
                            $member->permissions()->attach($permission->id, [
                                'created_at' => now(config('app.timezone')),
                                'updated_at' => now(config('app.timezone'))
                            ]);
                        }
                    }
                }
                #endregion
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}

<?php

namespace Dev\AdvancedRole\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

use Dev\AdvancedRole\Enums\ScopeEnum;
use Dev\AdvancedRole\Models\Scope;
use Dev\AdvancedRole\Models\Role;

class ScopeSeeder extends Seeder
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
            $this->command->info('Truncating Scopes tables');
            Scope::truncate();
        }

        $scopes = [
            [
                'display_name' => 'None',
                'name' => 'none',
                'description' => 'Không có quyền truy cập'
            ],
            [
                'display_name' => 'Basic',
                'name' => 'basic',
                'description' => 'Basic: chỉ cho phép truy cập các tài nguyên đang phụ trách'
            ],
            [
                'display_name' => 'Local',
                'name' => 'local',
                'description' => 'Local: chỉ cho phép truy cập các  tài nguyên trong phòng ban trực thuộc'
            ],
            [
                'display_name' => 'Deep',
                'name' => 'deep',
                'description' => 'Deep: cho phép truy cập các tài nguyên trong phòng ban trực thuộc và các phòng ban con của phòng ban đó'
            ],
            [
                'display_name' => 'Global',
                'name' => 'global',
                'description' => 'Global: cho phép truy cập toàn bộ tài nguyên tất cả phòng ban'
            ]
        ];

        foreach ($scopes as $key => $scope) {
            $this->command->info("Creating Scope {$scope['name']}");
            Scope::updateOrCreate([
                'name' => "{$scope['name']}",
            ], [
                'name' => $scope['name'],
                'display_name' => $scope['display_name'],
                'description' => $scope['description']
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}

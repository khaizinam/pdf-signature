<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Dev\Base\Supports\Database\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        // Create table for storing roles
        if (!Schema::hasTable('app_roles')) {
            Schema::create('app_roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        // Create table for storing permissions
        if (!Schema::hasTable('app_permissions')) {
            Schema::create('app_permissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        // Create table for storing teams
        if (!Schema::hasTable('app_teams')) {
            Schema::create('app_teams', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        // Create table for associating roles to members and teams (Many To Many Polymorphic)
        if (!Schema::hasTable('app__role_members')) {
            Schema::create('app__role_members', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id');
                $table->unsignedBigInteger('member_id');
                $table->string('user_type', 191);
                $table->unsignedBigInteger('team_id')->nullable();

                $table->foreign('role_id')->references('id')->on('app_roles')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('team_id')->references('id')->on('app_teams')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->unique(['member_id', 'role_id', 'user_type', 'team_id'], 'app__role_members_unique');
            });
        }

        // Create table for associating permissions to members (Many To Many Polymorphic)
        if (!Schema::hasTable('app__permission_members')) {
            Schema::create('app__permission_members', function (Blueprint $table) {
                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('member_id');
                $table->string('user_type', 191);
                $table->unsignedBigInteger('team_id')->nullable();

                $table->foreign('permission_id')->references('id')->on('app_permissions')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('team_id')->references('id')->on('app_teams')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->unique(['member_id', 'permission_id', 'user_type', 'team_id'], 'app__permission_members_unique');
            });
        }

        // Create table for associating permissions to roles (Many-to-Many)
        if (!Schema::hasTable('app__permission_roles')) {
            Schema::create('app__permission_roles', function (Blueprint $table) {
                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('role_id');

                $table->foreign('permission_id')->references('id')->on('app_permissions')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('app_roles')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->primary(['permission_id', 'role_id'], 'app__permission_roles_unique');
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app__permission_members');
        Schema::dropIfExists('app__permission_roles');
        Schema::dropIfExists('app_permissions');
        Schema::dropIfExists('app__role_members');
        Schema::dropIfExists('app_roles');
        Schema::dropIfExists('app_teams');
    }
};

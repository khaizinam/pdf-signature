<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                if (!Schema::hasColumn('members', 'username')) {
                    $table->string('username', 60)->unique()->nullable()->after('id');
                }
                if (!Schema::hasColumn('members', 'role_name')) {
                    $table->string('role_name', 60)->nullable()->after('remember_token')->comment('Bên MSSQL cũ là Nguoi_Su_Dung.MaNhom, có thể sẽ không sử dụng, chỉ dùng để đối chiếu data, xoá đi khi ổn định');
                }
                if (!Schema::hasColumn('members', 'department_room_id')) {
                    $table->unsignedBigInteger('department_room_id')->nullable()->after('remember_token')->comment('move tạm Bên MSSQL cũ là Nguoi_Su_Dung.MaPhong, Mã phòng cấp cứu (emergency room - ER)');
                    $table->foreign('department_room_id')->references('id')->on('app_departments')
                        ->onUpdate('cascade')->nullOnDelete();
                }
                if (!Schema::hasColumn('members', 'department_id')) {
                    $table->unsignedBigInteger('department_id')->nullable()->after('remember_token')->comment('move tạm Bên MSSQL cũ là Nguoi_Su_Dung.MaKhoa, Mã Khoa cấp cứu (emergency department - ED)');
                    $table->foreign('department_id')->references('id')->on('app_departments')
                        ->onUpdate('cascade')->nullOnDelete();
                }
                if (!Schema::hasColumn('members', 'last_login')) {
                    $table->timestamp('last_login')->nullable();
                }
                if (!Schema::hasColumn('members', 'expire_at')) {
                    $table->timestamp('expire_at')->nullable()->comment('Cho phép cài period expiration cho tài khoản');
                }
                if (!Schema::hasColumn('members', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
        if (Schema::hasTable('app_permissions')) {
            Schema::table('app_permissions', function (Blueprint $table) {
                if (!Schema::hasColumn('app_permissions', 'alias')) {
                    $table->json('alias')->nullable()->after('description')->default('{}')->comment('eg: {"remove","restore","for_delete"}, nhóm các hành vi liên quan hoặc giống nhau về mặt logic sử dụng');
                }
                if (!Schema::hasColumn('app_permissions', 'allowed_permissions')) {
                    $table->json('allowed_scopes')->nullable()->after('description')->default('{}')->comment('eg: {"local","none"}, để xác định các scopes cho phép sử dụng trên mỗi permission');
                }
                if (!Schema::hasColumn('app_permissions', 'reference_type')) {
                    $table->string('reference_type', 191)->nullable()->after('description')->comment('Áp dụng cho Entity (Resource), hoặc có thể quản lý theo dạng plugin_id/module_id');
                }
            });
        }
        if (Schema::hasTable('app_roles')) {
            Schema::table('app_roles', function (Blueprint $table) {
                if (!Schema::hasColumn('app_roles', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
        if (Schema::hasTable('app__role_members')) {
            Schema::table('app__role_members', function (Blueprint $table) {
                if (Schema::hasColumn('app__role_members', 'member_id')) {
                    $table->foreign('member_id')->references('id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
                }
                
                if (!Schema::hasColumn('app__role_members', 'created_at')) {
                    $table->timestamps();
                }
            });
        }

        if (Schema::hasTable('app_teams')) {
            Schema::table('app_teams', function (Blueprint $table) {
                if (!Schema::hasColumn('app_teams', 'author_id')) {
                    $table->string('author_type')->nullable()->after('description');
                    $table->unsignedBigInteger('author_id')->nullable()->after('description');
                }
                if (!Schema::hasColumn('app_teams', 'parent_id')) {
                    $table->unsignedBigInteger('parent_id')->nullable()->after('description');
                    $table->foreign('parent_id')
                        ->references('id')->on('app_teams')
                        ->cascadeOnUpdate()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('app_teams', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }

        if (Schema::hasTable('app__permission_roles')) {
            Schema::table('app__permission_roles', function (Blueprint $table) {
                if (!Schema::hasColumn('app__permission_roles', 'scope')) {
                    $table->enum('scope', ['none', 'basic', 'local', 'deep', 'global'])->nullable();
                    $table->foreign('scope')->references('name')->on('app_permission_scopes')
                        ->onUpdate('cascade')->onDelete('cascade');
                }
                if (!Schema::hasColumn('app__permission_roles', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
        if (Schema::hasTable('app__permission_members')) {
            Schema::table('app__permission_members', function (Blueprint $table) {
                if (!Schema::hasColumn('app__permission_members', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

    public function listTableIndexes($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableIndexes($table));
    }
};

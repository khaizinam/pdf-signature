<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * 
         * Permission theo CRUD - Records, cài đặt theo level từng action, gồm 5 level:
         * - Global: cho phép truy cập toàn bộ records/ resource tất cả phòng ban.
         * - Deep: cho phép truy cập các records/ resource trong phòng ban trực thuộc và các phòng ban con của phòng ban đó.
         * - Local: chỉ cho phép truy cập các records/ resource trong phòng ban trực thuộc.
         * - Basic: chỉ cho phép truy cập các records/ resource đang được assign.
         * - None: không có quyền truy cập.
         * Create table for associating permissions to roles (Many-to-Many)
         */
        Schema::create('app_permission_scopes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('name', ['none', 'basic', 'local', 'deep', 'global'])->unique()->nullable()->comment('global; deep; local; basic; none');
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();

            $table->timestamps();

            $table->comment('Thông tin Scope (Global: cho phép truy cập toàn bộ records/ resource tất cả phòng ban; Deep: cho phép truy cập các records/ resource trong phòng ban trực thuộc và các phòng ban con của phòng ban đó; Local: chỉ cho phép truy cập các records/ resource trong phòng ban trực thuộc; Basic: chỉ cho phép truy cập các records/ resource đang được assign;None: không có quyền truy cập)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_permission_scopes', function (Blueprint $table) {
            //
        });
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

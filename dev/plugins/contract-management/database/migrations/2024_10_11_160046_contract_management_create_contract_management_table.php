<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('contract_managements')) {
            Schema::create('contract_managements', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('file')->nullable()->comment('Link file pdf');
                $table->string('description')->nullable()->comment('Mô tả');
                $table->string('user_id')->nullable()->comment('Người đăng');
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('signatures')) {
            Schema::create('signatures', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255)->comment('Người ký tên');
                $table->string('file')->nullable()->comment('Link file chữ ký');
                $table->string('user_id')->nullable()->comment('Người đăng');
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('signature_contract')) {
            Schema::create('signature_contract', function (Blueprint $table) {
                $table->unsignedBigInteger('signature_id', 255)->comment('ID Chữ ký');
                $table->unsignedBigInteger('contract_id')->nullable()->comment('ID PDF họp đồng');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_managements');
        Schema::dropIfExists('signatures');
        Schema::dropIfExists('signature_contract');
    }
};

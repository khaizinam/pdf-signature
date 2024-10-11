<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contract_managements', function (Blueprint $table) {
            $table->string('file')->nullable()->after('status'); // Thêm cột image
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('file'); // Thêm cột user_id và ràng buộc khóa ngoại
        });
    }

    public function down(): void
    {
        Schema::table('contract_managements', function (Blueprint $table) {
            $table->dropColumn('file');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
